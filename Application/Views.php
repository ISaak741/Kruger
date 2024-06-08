<?php

namespace Application;

class Views
{
    public static function view($view, $array = null)
    {
        if (!is_null($array)) {
            $data = array_key_first($array);
            $$data = $array[$data];
        }

        $default = __DIR__ . '/../Views/404.php';
        $view = __DIR__ . "/../Views/$view.php";

        $result = require(file_exists($view) ? $view : $default);

        if (str_ends_with($result, "1"))
            $result = str_replace($result, '', '1');

        return $result;
    }
}
