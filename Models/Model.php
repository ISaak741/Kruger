<?php

namespace Models;

use Application\Database\Database;

abstract class Model
{
    public static $table;
    public static $cols;
    public static $hidden = [];
    public static $ID;
    public function save()
    {

        $attrs = implode(',', $this::$cols);
        $values = implode(',', array_map(function ($col) {
            if (is_string($col))
                return "'" . $this->$col . "'";
            else
                return $this->$col;
        }, $this::$cols));

        $query = 'INSERT INTO ' . $this::$table . "($attrs) VALUES ($values)";
        Database::$instance->query($query);
        $this->makeAttributes();
    }
    public function update()
    {

        $values = implode(',', array_map(function ($col) {
            return "$col = " . (is_string($this->$col) ? "'" . $this->$col . "'" : $this->$col);
        }, $this::$cols));

        $query = 'UPDATE ' . $this::$table . " SET $values WHERE " . $this::$ID . "=" . $this->${$this::$ID};

        Database::$instance->query($query);
        $this->makeAttributes();
    }

    public function delete()
    {

        $query = 'DELETE FROM ' . $this::$table . ' WHERE ' . $this::$ID . '=' . $this->{$this::$ID};
        Database::$instance->query($query);
    }

    public static function Find($val, $id = null)
    {

        $cls = get_called_class();
        $values = implode(',', array_merge($cls::$cols, $cls::$hidden, [$cls::$ID]));
        $attr = $id == null ? $cls::$ID : $id;
        $query = "SELECT $values FROM {$cls::$table} WHERE {$attr} = $val";

        $result = Database::$instance->query($query);
        $result = $result->fetch_all(MYSQLI_ASSOC)[0];

        $obj = new ($cls)();
        $keys = array_merge($obj::$cols, $obj::$hidden, [$obj::$ID]);

        foreach ($keys as $key)
            $obj->{$key} = $result[$key];

        return $obj;
    }

    public static function All()
    {

        $cls = get_called_class();
        $values = implode(',', array_merge($cls::$cols, [$cls::$ID]));
        $query = "SELECT $values FROM {$cls::$table}";

        $result = Database::$instance->query($query);
        $records = $result->fetch_all(MYSQLI_ASSOC);

        $objects = [];

        foreach ($records as $record) {
            $obj = new ($cls)();
            $keys = array_keys($record);
            foreach ($keys as $key)
                $obj->{$key} = $record[$key];

            $objects[] = $obj;
        }

        return $objects;
    }

    private function makeAttributes()
    {
        $query = "SELECT * FROM {$this::$table} WHERE {$this::$ID} = " . Database::$instance->insert_id;
        $result = Database::$instance->query($query);
        if ($result) {
            $data = $result->fetch_assoc();
            $keys = array_merge($this::$cols, $this::$hidden, [$this::$ID]);
            foreach ($keys as $key)
                $this->{$key} = $data[$key];
        }
    }
}
