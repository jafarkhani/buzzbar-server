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
use Api\Models\Group;


class GroupsController extends BaseController{

    protected $container;
    protected $Group;

    public function __construct(ContainerInterface $container, Group $Group){
        /*$this->container = $container;
        $this->Group = $Group;*/
        parent::__construct($container,$Group);
    }

} //End of class GroupController