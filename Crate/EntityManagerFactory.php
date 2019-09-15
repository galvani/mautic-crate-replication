<?php


namespace MauticPlugin\CrateReplicationBundle\Crate;

use Crate\PDO\PDO;
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

    public function __construct(CoreParametersHelper $parametersHelper)
    {
        $this->parametersHelper = $parametersHelper;
    }

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
        //var_dump($this->getMetadata()); die();
        //var_dump($config->getAutoGenerateProxyClasses()); die();
        $this->showSchemas();
        //$this->showTables();
        //$this->entityManager->getClassMetadata()->
        //$this->createTableSQLFromSc
        //hema('mautic', $this->getSchemaManager()->m)

        $dsn = explode('/', $this->parametersHelper->getParameter('crate')['dsn']); //@todo move to settings
        echo $schemaName = array_pop($dsn);
        echo "\n";
        $this->createSchema($schemaName);
        die();
        return $this->entityManager;
    }

    private $mappedMetadata = [];
    private $classMapping   = [];

    public function getMetadata()
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


    public function getSchemaManager()
    {
        return $this->getEntityManager()->getConnection()->getSchemaManager();
    }

    private function createSchema(string $name)
    {
        $existing = $this->showSchemas();
        /** @var ClassMetadata $metadata */
        foreach ($this->getMetadata() as $table => $metadata) {
            if (in_array($table, $existing)) {
                continue;
            }
            $sql = $this->createTableSQLFromSchema($metadata);
            var_dump($sql);
            $this->getEntityManager()->getConnection()->exec($sql);
        }

        $this->showSchemas();
    }

    private function fetchAll($query): array
    {
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function showSchemas()
    {
        $databases = $this->fetchAll('show schemas');
        $response  = array_map(function ($item) {
            return $item['schema_name'];
        }, $databases);
        return $response;
    }

    private function showTables(?string $schema = null, ?string $like = null): array
    {
        $tables = $this->fetchAll('show tables' . ($schema ? ' in ' . $schema : ''));
        var_dump($tables);
        die();
    }

    private function createTableSQLFromSchema(ClassMetadata $schema, ?string $schemaName=null): string
    {
        $fields = [];
        $sql = "CREATE TABLE "
            . ($schemaName!==null ? $schemaName .'.' : '')
            . $schema->getTableName() . " (";
        foreach ($schema->getFieldNames() as $fieldName) {

            $fieldMapping = $schema->getFieldMapping($fieldName);

            $sqlF = sprintf('%s %s'
                , $fieldMapping['columnName']
                , $fieldMapping['type']
            );

            $sqlF .= $fieldMapping['unique'] ? ' primary key' : '';
            $sqlF .= $fieldMapping['nullable']===true ? ' not null' : '';

            $fields[] = $sqlF;
        }
        $sql .= implode(', ', $fields) . ')';

        return $sql;
    }

    public function listTables()
    {
        $this->getSchemaManager()->listDatabases(); // => ['foo', 'bar'];
        foreach ($this->getSchemaManager()->listTables() as $table) {
            echo $table->getName() . "\n";
        }
    }

}