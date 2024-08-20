<?php

declare(strict_types=1);

namespace API\src\config;

use API\src\database\classes\Database_orm;
use API\src\database\classes\Database_pdo;
use API\src\database\classes\Database_query;
use API\src\services\Container;
use API\src\services\UserService;
use API\src\utilities\classes\Cache;
use API\src\utilities\classes\Encrypt;
use API\src\utilities\classes\Env_Reader;
use API\src\utilities\classes\jwt_class;
use API\src\utilities\classes\Logger;
use API\src\utilities\classes\Mail_Sender;
use API\src\utilities\classes\Redis;
use Psr\Container\ContainerInterface;

final class Dependency
{

    public  static function createContainer(): ContainerInterface
    {
        // Create Classes
        // Create Container
        $container = new Container();

        // Initialize and register Database ORM
        $container->set('database_orm', fn () => Database_orm::init());

        // Initialize and register PDO
        $container->set('database_pdo', fn () => Database_pdo::init());

        // Initialize and register db_query
        $container->set('database_query', fn () => new Database_query());

        // Register Logger
        $container->set('logger', fn () => new Logger());

        // Register Encrypt
        $container->set('encrypt', fn () => new Encrypt());

        // Register jwt_class
        $container->set('jwt_class', fn () => new jwt_class());

        // Register Mail_Sender
        $container->set('mail_sender', fn () => new Mail_Sender());

        // Register UserService
        $container->set(UserService::class, fn (ContainerInterface $container) => new UserService(
            $container->get('database_pdo'),
            $container->get('database_query')
        ));

        // Register env reader
        $container->set('env', fn () => new Env_Reader(APP_PATH . DIRECTORY_SEPARATOR . '.env'));
        // Register Redis
        $container->set('redis', function ($container) {
            $env_reader = $container->get('env');
            $host = $env_reader->getValue('REDIS_HOST');
            $port = $env_reader->getValue('REDIS_PORT');
            $password = $env_reader->getValue('REDIS_PASSWORD');
            return new Redis([
                'scheme' => 'tcp',
                'host' => $host,
                'port' => $port,
                'password' =>  $password,
            ]);
        });

        // Register Cache
        $container->set('cache', function () {
            $cache = new Cache();
            $cache->cleanExpired();
            return $cache;
        });



        // initialize database_orm
        $container->get('database_orm');

        // Return Container
        return $container;
    }
    public static function configurePHPSettings(): void
    {
        // Set error reporting to display all errors
   

        // Set maximum file upload size to 25MB
        ini_set('upload_max_filesize', '25M');

        // Set maximum POST size to 25MB
        ini_set('post_max_size', '25M');

        // Set maximum execution time to 300 seconds (5 minutes)
        ini_set('max_execution_time', '300');

        // Set memory limit to 128MB
        ini_set('memory_limit', '128M');
        
    }
}
