<?php


namespace MauticPlugin\CrateReplicationBundle\Crate;

use Crate\PDO\PDO;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use MauticPlugin\CrateReplicationBundle\Exception\ConfigurationException;
use MauticPlugin\CrateReplicationBundle\Exception\SchemaException;

class EntityManagerFactory
{
    /**
     * @var CoreParametersHelper
     */
    private $parametersHelper;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var array
     */
    private $mappedMetadata = [];

    /**
     * @var array
     */
    private $classMapping = [];

    /**
     * EntityManagerFactory constructor.
     *
     * @param CoreParametersHelper $parametersHelper
     */
    public function __construct(CoreParametersHelper $parametersHelper)
    {
        $this->parametersHelper = $parametersHelper;
    }

    /**
     * @return EntityManager
     * @throws ConfigurationException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     */
    public function getEntityManager(): EntityManager
    {
        if (isset($this->entityManager)) {
            return $this->entityManager;
        }

        $isDevMode = true; //@todo get elsewhere
        $paths     = [__DIR__ . '/Entity'];

        $crateParameters = $this->parametersHelper->getParameter('crate');

        if (!$crateParameters) {
            throw new ConfigurationException('Crate connection is not configured');
        }

        $params = [
            'driverClass' => 'Crate\DBAL\Driver\PDOCrate\Driver',
            'user'        => $crateParameters['user'],
            'dsn'         => $crateParameters['dsn'],
            'port'        => 4200
        ];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

        $this->entityManager = EntityManager::create($params, $config);

        $dsn        = explode('/', $this->parametersHelper->getParameter('crate')['dsn']); //@todo move to settings
        $schemaName = array_pop($dsn);
        $this->createSchema($schemaName);   // @todo not always

        return $this->entityManager;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        if (count($this->mappedMetadata)) {
            return $this->mappedMetadata;
        }

        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        /** @var ClassMetadata $classMetaData */
        foreach ($metadata as $classMetaData) {
            $this->mappedMetada[$classMetaData->getTableName()] = $classMetaData;
            $this->classMapping[$classMetaData->getName()]      = $classMetaData->getTableName();
        }
        return $this->mappedMetada;
    }

    /**
     * @return AbstractSchemaManager
     * @throws ConfigurationException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     */
    public function getSchemaManager(): AbstractSchemaManager
    {
        return $this->getEntityManager()->getConnection()->getSchemaManager();
    }

    /**
     * @param string $name
     *
     * @return void affected rows
     * @throws ConfigurationException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     */
    private function createSchema(string $name): void
    {
        $existing = $this->showTables($name);
        /** @var ClassMetadata $metadata */
        foreach ($this->getMetadata() as $table => $metadata) {
            if (in_array(strtolower($table), $existing, true)) {
                continue;
            }
            $sql = $this->createTableSQLFromSchema($metadata, $name);
            $this->getEntityManager()->getConnection()->exec($sql);
        }
    }

    /**
     * @param $query
     *
     * @return array
     * @throws ConfigurationException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     */
    private function fetchAll($query): array
    {
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string|null $schema
     * @param string|null $like
     *
     * @return array
     * @throws ConfigurationException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\Mapping\MappingException
     * @throws \Doctrine\ORM\ORMException
     */
    private function showTables(?string $schema = null, ?string $like = null): array
    {
        $tables = $this->fetchAll('show tables' . ($schema ? ' in ' . $schema : ''));
        $tables = array_map(function($el){
            return array_shift($el);
        },$tables);
        return $tables;
    }

    /**
     * @param ClassMetadata $schema
     * @param string|null   $schemaName
     *
     * @return string
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
   private function createTableSQLFromSchema(ClassMetadata $schema, ?string $schemaName = null): string
    {
        $fields = [];
        $sql    = "CREATE TABLE "
            . ($schemaName !== null ? $schemaName . '.' : '')
            . strtolower($schema->getTableName()) . " (";
        foreach ($schema->getFieldNames() as $fieldName) {

            $fieldMapping = $schema->getFieldMapping($fieldName);

            $sqlF = sprintf('%s %s'
                , $fieldMapping['columnName']
                , $fieldMapping['type']
            );

            $sqlF .= $fieldMapping['unique'] ? ' primary key' : '';
            $sqlF .= $fieldMapping['nullable'] === true ? ' not null' : '';

            $fields[] = $sqlF;
        }
        $sql .= implode(', ', $fields) . ')';

        return $sql;
    }
}