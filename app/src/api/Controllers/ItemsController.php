<?php
/**
 * Author: rmahdizadeh
 * Date: 1398-05-05
 */
namespace Api\Controllers;

use Interop\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use pdodb;
use ResponseHelper;
use config;
use Api\Models\Items;


class ItemsController{

    protected $container;
    protected $Items;

    public function __construct(ContainerInterface $container, Items $Items){
        $this->container = $container;
        $this->Items = $Items;
    }

} //End of class ItemsController