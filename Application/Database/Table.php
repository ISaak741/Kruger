<?php

namespace Application\Database;

class Table
{
    const  ADD_COLUMN = 'ADD';
    const DROP_COLUMN = 'DROP';
    const CREATE = 3;
    private $sql;
    private $cols;
    private $index;


    public static function dropColumns($table_name, $cols)
    {
        $table = Table::alter($table_name, null);
        $table->cols = $cols;
        $table->endQuery(Table::DROP_COLUMN);
        return $table;
    }

    public static function alter($table_name, $callback = null)
    {
        $table = new Table();
        $table->sql = "ALTER TABLE $table_name {cols}";
        if (is_null($callback))
            return $table;
        $table->run($callback, Table::ADD_COLUMN);
        return $table;
    }
    public static function  create($table_name, $callback)
    {
        $table = new Table();
        $table->sql = "CREATE TABLE IF NOT EXISTS $table_name({cols})";
        $table->run($callback);
        return $table;
    }
    private function __construct()
    {
        $this->cols = [];
        $this->index = -1;
    }

    public function timestamp($col_name)
    {
        $this->cols[++$this->index] = "$col_name TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        return $this;
    }

    public function enum($col_name, $vals)
    {
        $vals = implode(',', array_map(function ($val) {
            return "'$val'";
        }, $vals));

        $this->cols[++$this->index] = "$col_name enum($vals)";
        return $this;
    }
    public function increments($col_name)
    {
        $this->cols[++$this->index] = "$col_name INT PRIMARY KEY AUTO_INCREMENT";
        return $this;
    }

    public function varchar($col_name)
    {
        $this->cols[++$this->index] = "$col_name varchar(100)";
        return $this;
    }

    public function int($col_name)
    {
        $this->cols[++$this->index] = "$col_name INT";
        return $this;
    }

    public function default($val)
    {
        $this->cols[$this->index] .= "  DEFAULT '$val'";
        return $this;
    }

    public function unique()
    {
        $this->cols[$this->index] .= " UNIQUE";
        return $this;
    }

    public function not_null()
    {
        $this->cols[$this->index] .= " NOT NULL";
        return $this;
    }
    public function run($callback, $option = Table::CREATE)
    {
        $callback($this);
        $this->endQuery($option);
    }
    private function endQuery($option)
    {
        $this->cols = match ($option) {
            Table::ADD_COLUMN, Table::DROP_COLUMN =>  array_map(function ($col) use ($option) {
                return "$option $col";
            }, $this->cols),
            Table::CREATE => $this->cols
        };

        $this->cols = implode(',', $this->cols);
        $this->sql = str_replace('{cols}', $this->cols, $this->sql);
    }

    public function getStatement()
    {
        return $this->sql;
    }
}
