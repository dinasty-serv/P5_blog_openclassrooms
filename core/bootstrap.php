<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require 'config/config.php';


/**
 *
 */
// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$isDevMode = true;

// the connection configuration

$config = Setup::createAnnotationMetadataConfiguration($paths_entity, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

/**
 * Twig Init
 */

$loader = new \Twig\Loader\FilesystemLoader($paths_view);
$twig = new \Twig\Environment(
    $loader,
    [
    'cache' => '/path/to/compilation_cache',
    ]
);
