<?php
/**
 * Author: rmahdizadeh
 * Date: 1398-05-05
 */
namespace ProfPortfolio\Controllers;

use Slim\Container;
use ProfPortfolio\Controllers\BaseController;
/*
use Interop\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use pdodb;
use ResponseHelper;
use config;
*/

use ProfPortfolio\Models\IndicatorGroups;

class GroupsController extends BaseController{

    protected $container;
    protected $IndicatorGroups;

    public function __construct(Container $container){
		
        parent::__construct($container);
		$this->model = new IndicatorGroups();
        
    }

} //End of class GroupController