<?php
/**
 * Created by PhpStorm.
 * User: ehsani
 * Date: 12/31/18
 * Time: 12:32 PM
 */

// DIC configuration
use Api\Controllers\SuperGroupsController;
use Api\Controllers\GroupsController;

use Api\Models\SuperGroup;
use Api\Models\Groups;



use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;
use Api\ErrorList;
use Api\Classes\CreditsUtils;


$container = $app->getContainer();

PdoDataAccess::$settings = $container->get('settings');
// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Logger($settings['name']);
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

/* Database connection
 * Not used in this project
*/

$container['pdo'] = function ($c) {
    $settings = $c->get('settings')['default_db'];

    $_host = $settings['host'];
    $_user = $settings['user'];
    $_pass = $settings['pass'];
    $_default_db = $settings['dbname'];

    $pdo = new PDO("mysql:host=" . $_host . ";dbname=" . $_default_db, $_user, $_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    return $pdo;
};

//Save Header information in headerInfo instead of SESSION
$container['headerInfo'] = function ($c) {

    $request = $c->get('request');
    $headerKeys = HeaderKey::getConstants();
    $headers = $request->getHeaders();
    //print_r($headerKeys); die("*******");

    foreach ($headerKeys as $key => $value) {
        //echo $key;
        if (array_key_exists("HTTP_" . $key, $headers)) {
            $headers[str_replace('_', '-', $key)] = $headers["HTTP_" . $key];
        }
    }
    //print_r($headers); die("*******");
    foreach ($headers as $key => $value) {
        if (in_array($key, $headerKeys)) {

            if ($key === HeaderKey::USER_ID) {
                if (!InputValidation::validate($value[0], InputValidation::Pattern_EnAlphaNum, false)) {
                    $headers[$key][0] = ErrorList::INPUT_VALIDATION_FAILED;
                }
            } else {
                if ($key !== HeaderKey::H_TOKEN) {

                    if (!InputValidation::validate($value[0], InputValidation::Pattern_Num, false)) {
                        $headers[$key][0] = ErrorList::INPUT_VALIDATION_FAILED;
                    }
                }
            }
        }

    }

    return array(
        HeaderKey::PERSON_ID => $headers[HeaderKey::PERSON_ID][0],
        HeaderKey::USER_ID => $headers[HeaderKey::USER_ID][0],
        HeaderKey::USER_ROLES => $headers[HeaderKey::USER_ROLES][0],
        HeaderKey::SYS_KEY => $headers[HeaderKey::SYS_KEY][0],
        HeaderKey::IP_ADDRESS => $headers[HeaderKey::IP_ADDRESS][0],
        HeaderKey::H_TOKEN => $headers[HeaderKey::H_TOKEN][0],
        //HeaderKey::API_KEY => $headers[HeaderKey::API_KEY][0]

    );
    return array();
};

//$container['upload_directory'] = function () {
//    return ('/attachments/StudentWorkDocs/');
//};

$container[SuperGroupsController::class] = function ($c) {
    $SuperGroup = new SuperGroup($c->get('headerInfo'));
    return new SuperGroupsController($c,$SuperGroup);
};

$container[GroupsController::class] = function ($c) {
    $Groups = new Groups($c->get('headerInfo'));
    return new GroupsController($c,$Groups);
};

/*$container[LectureController::class] = function ($c) {
    $lecture = new lecture($c->get('headerInfo'));
    $doc = new DocAttachment($c->get('headerInfo'));
    return new LectureController($c,$lecture,$doc);
};*/
