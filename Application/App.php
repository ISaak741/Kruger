<?php

namespace Application;

use Controllers\Controller as Controller;
use Application\Database\Database;

class App
{
  public function __construct(public Request $req)
  {
    Database::init_database();
  }

  public function run()
  {
    $route_found = false;

    foreach (Router::$routes as $route)
      if ($route->matches($this->req)) {
        $route_found = true;
        $route->execute();
        break;
      }

    if (!$route_found) (new Controller())->_404();
  }
}
