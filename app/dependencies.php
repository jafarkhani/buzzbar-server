<?php
/**
 * Created by PhpStorm.
 * User: M.Fattahi
 * Date: 1399-02
 */

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

