<?php
use Core\Router;
require_once __DIR__ . '/autoload.php';

Router::initRoutes();
Router::dispatch();
