<?php
/**
 * Created by PhpStorm.
 * User: sajjadi
 * Date: 12/31/18
 * Time: 3:24 PM
 */

// Api Routes
$app->group('/sportclass/api/v1', function () {

});


// Define app routes
$app->get('/', function ($request, $response, $args) {
    //echo $_SERVER['DOCUMENT_ROOT'];
        return $response->write("Hello***** " );
});

$app->get('/hello/{name}', function($request, $response, $args) {

    return $response->write( "Hello, " . $args['name']);
});
