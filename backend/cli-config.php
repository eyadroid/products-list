<?php

require __DIR__ . '/vendor/autoload.php';
use App\Utils\EntityManager;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/');
$dotenv->load();
$entityManager = EntityManager::getInstance();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
