<?php
/**
 * Created by PhpStorm.
 * User: ehsani
 * Date: 12/31/18
 * Time: 8:37 AM
 */

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
// Create and configure Slim app
require "../vendor/autoload.php";

$settings = require  __DIR__ . '/../app/settings.php';

use \Slim\App;

session_start();

$app = new App($settings);

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register middleware
require __DIR__ . '/../app/middleware.php';


// Register routes
require __DIR__ . '/../app/routes.php';
// Run app
$app->run();

