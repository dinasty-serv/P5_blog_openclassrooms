<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require 'config/config.php';


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
