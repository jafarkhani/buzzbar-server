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
set_include_path(get_include_path() . PATH_SEPARATOR . getenv("DOCUMENT_ROOT") . "/core");

use \Slim\App;

session_start();

$settings = require  __DIR__ . '/../app/settings.php';
$app = new App($settings);

require __DIR__ . '/../app/dependencies.php';
require __DIR__ . '/../app/middleware.php';
require __DIR__ . '/../app/routes.php';

$app->run();

