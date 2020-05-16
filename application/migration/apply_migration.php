<?php
$scriptStart = microtime(true);

require_once dirname(__FILE__) . '/../envvars.php';
require_once dirname(__FILE__) . '/../libraries/Doctrine.php';
$doctrine = new \Doctrine;

// get migrations files list
$migrFiles = scandir(dirname(__FILE__) . '/dumps', SCANDIR_SORT_DESCENDING);

if (!empty($migrFiles)) {
    // remove directory dots:
    $migrFiles = array_slice($migrFiles, 0, -2);

    // get current db_version
    $dbVersion = $doctrine->em->getRepository('models\Migration')->findOneByKey('db_version');
    $dbRunning = $doctrine->em->getRepository('models\Migration')->findOneByKey('updater_running');

    if (!$dbRunning) {
        $dbRunning = new \models\Migration;
        $dbRunning->setKey('updater_running');
        $dbRunning->setType('integer');
        $doctrine->em->persist($dbRunning);
    }

    // all applications should to know, that schema update running
    $dbRunning->setValue('1');
    $doctrine->em->flush();

    if (!$dbVersion) {
        // not found db_version? - create it as last dump
        $dbVersion = new \models\Migration;
        $dbVersion->setKey('db_version');
        $dbVersion->setType('string');
        $doctrine->em->persist($dbVersion);
    } else {
        // get migrations order for apply
        array_splice($migrFiles, array_search($dbVersion->getValue() . '.php', $migrFiles));
    }

    $conn = $doctrine->em->getConnection();
    sort($migrFiles, SORT_NUMERIC);

    echo "current version " . $dbVersion->getValue() . "\n";
    echo count($migrFiles) . " migrations to apply\n\n";

    foreach ($migrFiles as $f) {
        try {
            require_once dirname(__FILE__) . '/dumps/' . $f;
            $migrationMark = substr($f, 0, -4);
            echo "applying {$migrationMark} ...\n";
            $queriesVariable = 'queries_' . $migrationMark;
            foreach ($$queriesVariable as $k => $q) {
                echo "  trying query #{$k} ... ";
                $conn->executeQuery('SET FOREIGN_KEY_CHECKS=0');
                $conn->executeQuery($q);
                echo "OK!\n";
            }
            $dbVersion->setValue($migrationMark);
            $doctrine->em->flush();
        } catch (\Exception $e) {
            $date = new \DateTime("now");
            $file = fopen(APPPATH . 'logs/log_migration_' . $date->format("Y-m-d") . '.log', 'a+');
            fwrite($file, $date->format("Y-m-d H:i:s") . ' | Error in file $migrationFile : ' . $e->getMessage() . PHP_EOL);
            fclose($file);
        }
    }

    $dbRunning->setValue('0');
    $doctrine->em->flush();
}

$scriptEnd = microtime(true);
$scriptTime = round($scriptEnd - $scriptStart, 2);
echo "----------------------------------\n";
echo "elapsed time: $scriptTime sec\n\n";