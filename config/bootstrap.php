<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\App;

require dirname(__DIR__) . '/vendor/autoload.php';
$path= dirname(__DIR__) .'/App/Entity/';

$isDevMode=true;
$config=Setup::createAnnotationMetadataConfiguration([$path],$isDevMode);

$conn = ['driver' => 'pdo_sqlite', 'path' => '', 'pdo' => App::Getdb()];
$entityManager = EntityManager::create($conn, $config);
