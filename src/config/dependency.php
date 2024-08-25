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
use Slim\Views\Twig;
use Twig\Loader\FilesystemLoader;

final class Dependency
{
    public static function createContainer(): ContainerInterface
    {
        $container = new Container();

        self::registerServices($container);
        self::initializeOrmDatabase($container);

        return $container;
    }

    private static function registerServices(Container $container): void
    {
        $container->set('database_orm', fn() => Database_orm::init());
        $container->set('database_pdo', fn() => Database_pdo::init());
        $container->set('database_query', fn() => new Database_query());
        $container->set('logger', fn() => new Logger());
        $container->set('encrypt', fn() => new Encrypt());
        $container->set('jwt_class', fn() => new jwt_class());
        $container->set('mail_sender', fn() => new Mail_Sender());
        $container->set(UserService::class, fn(ContainerInterface $container) => new UserService(
            $container->get('database_pdo'),
            $container->get('database_query')
        ));
        $container->set('env', fn() => new Env_Reader(APP_PATH . DIRECTORY_SEPARATOR . '.env'));
        $container->set('redis', fn(ContainerInterface $container) => self::createRedis($container));
        $container->set('cache', fn() => self::createCache());
        $container->set('view', fn() => self::createTwig());
    }

    private static function initializeOrmDatabase(Container $container): void
    {
        $container->get('database_orm');
    }

    private static function createRedis(ContainerInterface $container): Redis
    {
        $env_reader = $container->get('env');
        $host = $env_reader->getValue('REDIS_HOST');
        $port = $env_reader->getValue('REDIS_PORT');
        $password = $env_reader->getValue('REDIS_PASSWORD');
        return new Redis([
            'scheme' => 'tcp',
            'host' => $host,
            'port' => $port,
            'password' => $password,
        ]);
    }

    private static function createCache(): Cache
    {
        $cache = new Cache();
        $cache->cleanExpired();
        return $cache;
    }

    private static function createTwig(): Twig
    {
        $loader = new FilesystemLoader(APP_PATH . DS . 'src' . DS . 'pages');
        return new Twig($loader, [
            'cache' => APP_PATH . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'twig',
            'auto_reload' => true,        // update the template if the original source changed
            'debug' => true,              // only for development
            'strict_variables' => true,   // to ignore invalid variables
            'charset' => 'utf-8',         // set the charset
            'optimizations' => -1,        // to enable all optimizations
            'autoescape' => 'html',       // set the autoescaping
        ]);
    }

    public static function configurePHPSettings(): void
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        ini_set('upload_max_filesize', '25M');
        ini_set('post_max_size', '25M');
        ini_set('max_execution_time', '300');
        ini_set('memory_limit', '128M');
    }
}
