<?php


namespace MauticPlugin\CrateReplicationBundle\Crate;


use Crate\PDO\PDO;
use Doctrine\DBAL\DriverManager;
use Mautic\CoreBundle\Helper\CoreParametersHelper;

class Connection extends PDO
{
    /**
     * @var
     */
    private $parametersHelper;

    public function __construct(CoreParametersHelper $parametersHelper)
    {
        $parameters = $parametersHelper->getParameter('crate');

        var_dump($parameters); die();
        parent::__construct($dsn, $username, $passwd, $options);
        $this->parametersHelper = $parametersHelper;
    }

    public function getEntityManager() {
        $params = array(
            'driverClass' => 'Crate\DBAL\Driver\PDOCrate\Driver',
            'user' => 'crate',
            'host' => 'localhost',
            'port' => 4200
);


$connection = \Doctrine\DBAL\DriverManager::getConnection($params);
$schemaManager = $connection->getSchemaManager();
    }
}