<?php

namespace Application\Database;

class Database
{
    public static $instance = null;
    private function __construct()
    {
        $config_db_path = __DIR__ . '/../../Public/config.json';
        $db_config = json_decode(file_get_contents($config_db_path, true));
        Database::$instance = new \Mysqli(
            $db_config->DB_HOST,
            $db_config->DB_USER,
            $db_config->DB_PASSWORD,
            $db_config->DB_NAME
        );
    }

    public static function init_database()
    {
        if (self::$instance == null)
            new Database();
        return;
    }
}
