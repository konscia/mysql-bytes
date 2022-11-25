<?php

use Konscia\MysqlBytes\App;

require 'vendor/autoload.php';

$config = require __DIR__ . '/config.php';

$app = new App($config);
$cli = $app->getCli();
$database = $app->getConn();

$cli->title('==== MySQL Bytes ====');

$argumentos = $argv;

/* 1 - SHOW DATABASE LIST IF WE DON'T HAVE AN ARGUMENT */

if (count($argumentos) <> 2) {
    $databasesList = $database->getDatabasesList();
    $cli->title('Principais Tabelas (>1000mb)');
    $cli->tableWithNameAndSizeInMB($databasesList, 1000);

    return 0;
}

/* 2 - SHOW DATABASE SIZE AND BIG TABLES */

$databaseNameToSearch = $argv[1];
$databaseData = $database->getDatabaseSize($databaseNameToSearch);
if ($databaseData === false) {
    $cli->error('Base de dados não localizada.');

    return 0;
}

$name = $databaseData['name'];
$totalSize = (int)$databaseData['total_size_in_bytes'];
$totalSizeInMb = number_format($totalSize / 1024 / 1024, 1, '.', '_') . 'MB';

$cli->title('Tamanho da Base');
$cli->successKeyValue($name, $totalSizeInMb);

$tableSize = $database->getTablesSize($databaseNameToSearch);
$cli->title('Principais Tabelas (>100mb)');
$cli->tableWithNameAndSizeInMB($tableSize, 100);

return 0;