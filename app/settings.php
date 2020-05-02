<?php
/**
 * Created by PhpStorm.
 * User: sajjadi
 * Date: 12/31/18
 * Time: 12:26 PM
 */
echo 'show connection vars';
echo $db_servers['master']["host"];
        echo $db_servers['master']["profportfolio_db "];
        echo $db_servers['master']["profportfolio_user "];
        echo $db_servers['master']["profportfolio_pass"];
echo 'end';

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'hashSalt' => 'M1cr0S3rv1c3#1398@StW*',
        //'APIKey' => 'AIzaSyClzfrOzB818x55$FASHvX4JuGQ!ciR9lv7q',
        // Monolog settings
        'logger' => [
            'name' => 'profportfolio-service',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        

        "default_db" => [
            "host" => config::$db_servers['master']["host"],
            "dbname" => config::$db_servers['master']["profportfolio_db "],
            "user" => config::$db_servers['master']["profportfolio_user "],
            "pass" => config::$db_servers['master']["profportfolio_pass"]
        ]
    ],
];