<?php

namespace App\Utils;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;

class EntityManager
{
    /**
     * @var DoctrineEntityManager
     */
    protected static $_instance;

    /**
     * Creates instance and returns it on subsequent calls
     * 
     * @returns _instance
     */
    public static function getInstance()
    {
        if(self::$_instance === null) {
            $isDevMode = $_ENV['APP_ENV'] === 'local';
            $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../entities"), $isDevMode);

            // database configuration parameters
            if ($_ENV['DATABASE_DRIVER'] == 'sqlite') {
                $conn = [
                    'driver' => 'pdo_sqlite',
                    'path' => __DIR__ . '/../db.sqlite',
                ];
            } else {
                $conn = [
                    'driver' => 'pdo_mysql',
                    'user' => $_ENV['DATABASE_USER'],
                    'password' => $_ENV['DATABASE_PASSWORD'],
                    'dbname' => $_ENV['DATABASE_NAME'],
                ];
            }

            // call constructor with given options and assign instance
            self::$_instance = DoctrineEntityManager::create($conn, $config);
        }

        return self::$_instance;
    }

    /**
     * Creates new instance
     * 
     * @return void
     */
    private function __construct()
    {
        //
    }

    /**
     * Singletons may not be cloned
     */
    private function __clone()
    {
    }

    /**
     * Delegate every method call to PDO instance
     *  
     * @param  String $method
     * @param  Array  $args
     * @return Mixed
     */    
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->_instance, $method), $args);
    }
}
