<?php

require 'vendor/autoload.php';

$migration_to_delete = $argv[1];
if (is_null($migration_to_delete)) {
    echo 'enter a valid migration name' . PHP_EOL;
    exit;
}

use Models\Migration;

Application\Database\Database::init_database();

$migration = Migration::Find("'$migration_to_delete'", 'migration');
$migration->delete();

require "Migrations/$migration_to_delete.php";
(new $migration_to_delete())->down();

echo "Migration $migration_to_delete is down at " . (new \DateTime())->format('Y-m-d H:i:s') . PHP_EOL;
