<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once __DIR__.'/../libraries/Doctrine.php';
// replace with mechanism to retrieve EntityManager in your app

$doctrine = new Doctrine();
$entityManager = $doctrine->em;

return ConsoleRunner::createHelperSet($entityManager);