<?php
/**
 * Author: rmahdizadeh
 * Date: 1398-05-05
 */
namespace ProfPortfolio\Controllers;

use Slim\Container;
use Utils\BaseController;

use ProfPortfolio\Models\FormHeader;

class FormHeaderController extends BaseController{

    protected $container;

    public function __construct(Container $container){
		
        parent::__construct($container);
		$this->model = new FormHeader();
        
    }

} //End of class GroupController