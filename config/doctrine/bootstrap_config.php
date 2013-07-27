<?php
// bootstrap_doctrine.php

// See :doc:`Configuration <../reference/configuration>` for up to date autoloading details.
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// See :doc:`Configuration <../reference/configuration>` for up to date autoloading details.
require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for XML Mapping
$isDevMode = true;
$config = Setup::createXMLMetadataConfiguration(__DIR__."/config/mappings/xml", $isDevMode);
// or if you prefer yaml or annotations
//$config = Setup::createAnnotationMetadataConfiguration(__DIR__."/entities", $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(__DIR__."/config/mappings/yml", $isDevMode);

// database configuration parameters
$conn = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'zfdoctrine2',
    'user'     => 'test',
    'password' => 'test'
);

// obtaining the entity manager
$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);
