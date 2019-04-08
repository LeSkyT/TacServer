<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->setDefaultModule("frontend");

return $router;