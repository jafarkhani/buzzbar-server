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
use Api\Models\Item;


class ItemsController extends BaseController{

    protected $container;
    protected $Item;

    public function __construct(ContainerInterface $container, Item $Item){
        /*$this->container = $container;
        $this->Item = $Item;*/
        parent::__construct($container,$Item);
    }

} //End of class ItemsController