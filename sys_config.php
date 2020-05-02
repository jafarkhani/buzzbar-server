<?php


class sys_config
{
    public static $db_server = array (
        "driver"   => "",
        "host"     => "",
        "database" => "",
        "user"     => "",
        "pass"     => ""
    );


}
sys_config::$db_server = array (
    "driver" => config::$db_servers['master']["driver"],
    "host" => config::$db_servers['master']["host"],
    "dbname" => config::$db_servers['master']["profportfolio_db"],
    "user" => config::$db_servers['master']["profportfolio_user"],
    "pass" => config::$db_servers['master']["profportfolio_pass"]
);