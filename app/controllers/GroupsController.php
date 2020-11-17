<?php
/**
 * Author: rmahdizadeh
 * Date: 1398-05-05
 */
namespace ProfPortfolio\Controllers;

use Slim\Container;
use Utils\BaseController;

use ProfPortfolio\Models\IndicatorGroups;

class GroupsController extends BaseController{

    protected $container;
    protected $IndicatorGroups;

    public function __construct(Container $container){
		
        parent::__construct($container);
		$this->model = new IndicatorGroups();
        
    }

} //End of class GroupController