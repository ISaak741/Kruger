<?php

namespace Application;

class Router
{
  static $routes = [];

  public $url, $method, $exec;
  function __construct($item)
  {
    [$this->url, $this->method, $this->exec] = $item;
  }
  public function execute()
  {
    $data = null;
    if (count($this->exec) == 3)
      [$class, $method, $data] = $this->exec;
    else
      [$class, $method] = $this->exec;
    if ($data == null) (new $class())->$method();
    else (new $class())->$method($data);
  }

  public function matches($route)
  {
    if ($route->method != $this->method)
      return false;

    if (strtolower($this->url) == strtolower($route->url))
      return true;

    $virtual_url_parts = explode('/', $this->url);
    $real_url_parts = explode('/', $route->url);

    if (count($virtual_url_parts) != count($real_url_parts))
      return false;

    $data = [];
    for ($i = 0; $i < count($real_url_parts); $i++)
      if (preg_match('/^[A-Za-z_]+/', $virtual_url_parts[$i]) && strtolower($virtual_url_parts[$i]) != strtolower($real_url_parts[$i]))
        return false;
      else if (preg_match('/\{([a-zA-Z_]+)\}/', $virtual_url_parts[$i]))
        $data[] = $real_url_parts[$i];

    if (!empty($data)) {
      $this->exec[] = count($data) == 1 ? $data[0] : $data;
      return true;
    }

    return false;
  }

  private static function make_route($route)
  {
    array_push(Router::$routes, new Router($route));
  }

  public static function get($url, $action)
  {
    self::make_route([$url, 'GET', $action]);
  }

  public static function post($url, $action)
  {
    self::make_route([$url, 'POST', $action]);
  }

  public static function delete($url, $action)
  {
    self::make_route([$url, 'DELETE', $action]);
  }

  public static function put($url, $action)
  {
    self::make_route([$url, 'PUTS', $action]);
  }
}
