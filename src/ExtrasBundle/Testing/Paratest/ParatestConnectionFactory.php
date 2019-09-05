<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 21.09.18
 * Time: 18:21
 */


namespace ExtrasBundle\Testing\Paratest;


use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;

class ParatestConnectionFactory extends ConnectionFactory
{

    public function createConnection(array $params, Configuration $config = null, EventManager $eventManager = null, array $mappingTypes = array())
    {
        $dbName = $this->getDbNameFromEnv(null);

        if ('ExtrasBundle\Development\DBAL\Sqlite\ModifiedDriver' === $params['driverClass']) {
            $params['path'] = str_replace('__DBNAME__', $dbName, $params['path']);
        } else {
            $params['dbname'] = $dbName;
        }

        return parent::createConnection($params, $config, $eventManager, $mappingTypes);
    }


    private function getDbNameFromEnv($dbName)
    {

        return 'dbTest' . getenv('TEST_TOKEN');
    }

}