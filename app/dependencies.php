<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

$container = $app->getContainer();
$container["headerInfo"] = HeaderControl::getHeaderInfo($container);

PdoDataAccess::$settings = $container->get('settings');
PdoDataAccess::$headerInfo = $container["headerInfo"];
DataAudit::$headerInfo = $container["headerInfo"];

// monolog
$container['logger'] = function ($container) {
	
	$config = $container->get('settings')['logger'];

    $logger = new Monolog\Logger($config['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($config['path'], $config['level']));

    return $logger;
};


$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
       
		$errorDesc = $exception->getMessage() . " file:" . $exception->getFile() . " line " . $exception->getLine();
        $container['logger']->critical($errorDesc);
		
        $response = $container['response'];
		
		return $response->withJson(['errors' => $errorDesc], 200);
		
        //return $response->withJson(['errors' => 'Something went wrong!'], 500);
    };
};