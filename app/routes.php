<?php
/**
 * Created by PhpStorm.
 * User: M.Fattahi
 * Date: 1399-02
 */

use ProfPortfolio\Controllers\GroupsController;

$app->group('/api/v1', function () {
	
	$this->get('/groups/select/{id}', 'ProfPortfolio\Controllers\GroupsController:find');
	$this->get('/groups/selectAll', function( $request,  $response, array $args){
		
		echo "----";
		$c = $this;
		new GroupsController($c);
		echo "----";

//'ProfPortfolio\Controllers\GroupsController:selectAll'
	});
	
    $this->post('/groups/insert', GroupsController::class . ':insert')->setName('Groups.insert');
    $this->post('/groups/update', GroupsController::class . ':update')->setName('Groups.update');
    $this->delete('/groups/delete/{id}', GroupsController::class . ':delete')->setName('Groups.delete');

    $this->get('/formtypes/select/{id}', FormTypesController::class . ':select')->setName('FormTypes.select');
    $this->get('/formtypes/selectAll', FormTypesController::class . ':selectAll')->setName('FormTypes.selectAll');
    $this->post('/formtypes/insert', FormTypesController::class . ':insert')->setName('FormTypes.insert');
    $this->post('/formtypes/update', FormTypesController::class . ':update')->setName('FormTypes.update');
    $this->delete('/formtypes/delete/{id}', FormTypesController::class . ':delete')->setName('FormTypes.delete');

    $this->get('/items/select/{id}', ItemsController::class . ':select')->setName('Items.select');
    $this->get('/items/selectAll', ItemsController::class . ':selectAll')->setName('Items.selectAll');
    $this->post('/items/insert', ItemsController::class . ':insert')->setName('Items.insert');
    $this->post('/items/update', ItemsController::class . ':update')->setName('Items.update');
    $this->delete('/items/delete/{id}', ItemsController::class . ':delete')->setName('Items.delete');

    $this->get('/formcalendars/select/{id}', FormCalendarsController::class . ':select')->setName('FormCalendars.select');
    $this->get('/formcalendars/selectAll', FormCalendarsController::class . ':selectAll')->setName('FormCalendars.selectAll');
    $this->post('/formcalendars/insert', FormCalendarsController::class . ':insert')->setName('FormCalendars.insert');
    $this->post('/formcalendars/update', FormCalendarsController::class . ':update')->setName('FormCalendars.update');
    $this->delete('/formcalendars/delete/{id}', FormCalendarsController::class . ':delete')->setName('FormCalendars.delete');
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

