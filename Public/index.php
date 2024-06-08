<?php


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/app.php';

use Application\Request;
use Application\App;


$req = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
$app = new App($req);
$app->run();
