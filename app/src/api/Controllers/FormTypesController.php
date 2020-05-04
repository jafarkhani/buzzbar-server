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
use Api\Models\FormTypes;


class FormTypesController{

    protected $container;
    protected $FormTypes;

    public function __construct(ContainerInterface $container, FormTypes $FormTypes){
        $this->container = $container;
        $this->FormTypes = $FormTypes;
    }

} //End of class FormTypesController