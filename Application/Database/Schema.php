<?php

namespace Application\Database;

class Schema
{
    public static function create($table_name, $callback)
    {
        Database::init_database();
        $table = Table::create($table_name, $callback);
        Database::$instance->query($table->getStatement());
    }
    public static function drop($table_name)
    {
        Database::init_database();
        $query = "DROP TABLE IF EXISTS $table_name";
        Database::$instance->query($query);
    }
    public static function alter($table_name, $callback)
    {
        Database::init_database();
        $table = Table::alter($table_name, $callback);
        Database::$instance->query($table->getStatement());
    }

    public static function dropColumnIfExists($table_name, $cols)
    {
        Database::init_database();
        $table = Table::dropColumns($table_name, $cols);
        Database::$instance->query($table->getStatement());
    }
}
