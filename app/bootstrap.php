<?php


use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("src");
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'symfony',
    'password' => 'Hallucinations0617!K',
    'dbname'   => 'blog_doctrine',
);

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/src'), $isDevMode,   $proxyDir, $cache, $useSimpleAnnotationReader);

function getEntityManager()
{
    try {
        return EntityManager::create($dbParams, $config);
    } catch (\Doctrine\ORM\ORMException $e) {
        echo $e->getMessage();
    }
}

getEntityManager($dbParams, $config);