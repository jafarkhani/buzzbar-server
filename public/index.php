<?php

// Create and configure Slim app
require "../vendor/autoload.php";

use \Slim\App;

session_start();

$app = new App();

require __DIR__ . '/../app/routes.php';

$app->run();

