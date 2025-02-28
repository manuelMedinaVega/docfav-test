<?php

require_once __DIR__.'/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$paths = [__DIR__.'/../Domain/Entity'];
$isDevMode = true;

$dbParams = [
    'driver' => 'pdo_mysql',
    'user' => 'docfav',
    'password' => 'secret',
    'host' => 'mysql',
    'port' => 3306,
    'dbname' => 'docfav',
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

return $entityManager;
