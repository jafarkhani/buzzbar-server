<?php
/**
 * Author: rmahdizadeh
 * Date: 1398-05-05
 */
namespace ProfPortfolio1\Controllers;

use Slim\Container;
use Utils\BaseController;

use ProfPortfolio1\Models\IndicatorGroups;

class IndicatorGroupController extends BaseController{

    protected $container;
    protected $IndicatorGroups;

    public function __construct(Container $container){
		
        parent::__construct($container);
		$this->model = new IndicatorGroups();
        
    }

} //End of class GroupController