<?php


require 'vendor/autoload.php';


Application\Database\Database::init_database();

$applied_migrations = array_map(function ($migration) {
    return $migration->migration;
}, Models\Migration::All());


$path = __DIR__ . '/Migrations/';

$all_migrations = array_values(
    array_filter(array_map(function ($item) {
        if (!($item == '.' || $item == '..'))
            return str_replace('.php',  '', $item);
        return null;
    }, scandir($path)), function ($item) {
        if (!is_null($item))
            return $item;
    })
);



$pending_migrations = array_diff($all_migrations, $applied_migrations);

foreach ($pending_migrations as $mgrt) {
    require "Migrations/$mgrt.php";
    (new $mgrt())->up();
    echo "Migration $mgrt is appalied at " . (new \DateTime())->format('Y-m-d H:i:s') . PHP_EOL;
    $migration = new Models\Migration();
    $migration->migration = $mgrt;
    $migration->save();
}
