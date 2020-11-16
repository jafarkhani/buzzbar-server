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
use Api\Models\FormType;


class FormTypesController extends BaseController{

    protected $container;
    protected $FormType;

    public function __construct(ContainerInterface $container, FormType $FormType){
        /*$this->container = $container;
        $this->FormType = $FormType;*/
        parent::__construct($container,$FormType);
    }

} //End of class FormTypesController