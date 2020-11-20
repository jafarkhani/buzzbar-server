<?php
/**
 * Created by PhpStorm.
 * User: M.Fattahi
 * Date: 1399-02
 */

$app->group('/api/v1', function () {
	
	$this->get('/domain/selectDeputies', 'ProfPortfolio\Controllers\DomainController:selectDeputies');
	
	$this->get('/IndicatorGroups/select/{id}', 'ProfPortfolio\Controllers\IndicatorGroupController:find');
	$this->get('/IndicatorGroups/selectAll', 'ProfPortfolio\Controllers\IndicatorGroupController:selectAll');
	
    $this->post('/groups/insert', GroupsController::class . ':insert')->setName('Groups.insert');
    $this->post('/groups/update', GroupsController::class . ':update')->setName('Groups.update');
    $this->delete('/groups/delete/{id}', GroupsController::class . ':delete')->setName('Groups.delete');

});

/*$app->delete('/profportfolio/api/v1/supergroups/delete/{id}', function ($request, $response, $args) {
    //echo $_SERVER['DOCUMENT_ROOT'];
        return $response->write("delete 1234***** ".$args['id']);
});*/

// Define app routes
$app->get('/', function ($request, $response, $args) {
    //echo $_SERVER['DOCUMENT_ROOT'];
        return $response->write("Hello 1234***** ");
});
$app->get('/test', function ($request, $response, $args) {
    //echo $_SERVER['DOCUMENT_ROOT'];
        return $response->write(" test " );
});

$app->get('/helo/{name}', function($request, $response, $args) {

    return $response->write( "Hello, 111 " . $args['name']);
});

