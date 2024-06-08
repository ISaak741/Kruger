<?php

use Application\Router;

Router::get("/", [Controllers\Controller::class, 'index']);
