<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------


$app->group('/api/v1', function () {
	
	$this->get('/domain/selectDeputies', 'ProfPortfolio\Controllers\DomainController:selectDeputies');
	$this->get('/domain/selectDeputies/{id}', 'ProfPortfolio\Controllers\DomainController:selectDeputies');
	
	$this->get('/IndicatorGroups/select/{id}', 'ProfPortfolio\Controllers\IndicatorGroupController:find');
	$this->get('/IndicatorGroups/selectAll', 'ProfPortfolio\Controllers\IndicatorGroupController:selectAll');
	$this->post('/IndicatorGroups/save', 'ProfPortfolio\Controllers\IndicatorGroupController:save');
	$this->get('/IndicatorGroups/delete/{id}', 'ProfPortfolio\Controllers\IndicatorGroupController:delete');
	
	$this->get('/FormHeader/selectAll', 'ProfPortfolio\Controllers\FormHeaderController:selectAll');
	$this->post('/FormHeader/save', 'ProfPortfolio\Controllers\FormHeaderController:save');
	
    

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

