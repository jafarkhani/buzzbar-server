<?php
/**
 * Created by PhpStorm.
 * User: sajjadi
 * Date: 12/31/18
 * Time: 3:24 PM
 */
error_reporting(1);
ini_set("display_errors", E_ALL);
use Api\Controllers\SuperGroupsController;
use Api\Controllers\GroupsController;

// Api Routes

$app->group('/profportfolio/api/v1', function () {
	$app->get('/supergroups/select', function ($request, $response, $args) {
    //echo $_SERVER['DOCUMENT_ROOT'];
        return $response->write(" Super Groups Select***** " );
});
    //$this->get('/supergroups/select/{id}', SuperGroupsController::class . ':select')->setName('SuperGroups.select');
    $this->get('/supergroups/selectAll', SuperGroupsController::class . ':selectAll')->setName('SuperGroups.selectAll');
    /*$this->post('/supergroups/select[/{params:.*}]', SuperGroupsController::class . ':select')->setName('SuperGroups.select');// params is the optional query parameters for selection*/
    $this->post('/supergroups/insert', SuperGroupsController::class . ':insert')->setName('SuperGroups.insert');
    $this->put('/supergroups/update/{id}', SuperGroupsController::class . ':update')->setName('SuperGroups.update');
    $this->delete('/supergroups/delete/{id}', SuperGroupsController::class . ':delete')->setName('SuperGroups.delete');

    $this->post('/groups/select', GroupsController::class . ':select')->setName('Groups.select');
});



// Define app routes
$app->get('/', function ($request, $response, $args) {
    //echo $_SERVER['DOCUMENT_ROOT'];
        return $response->write("Hello***** " );
});
$app->get('/super', function ($request, $response, $args) {
    //echo $_SERVER['DOCUMENT_ROOT'];
        return $response->write(" Super Groups Select***** " );
});

$app->get('/hello/{name}', function($request, $response, $args) {

    return $response->write( "Hello, " . $args['name']);
});

