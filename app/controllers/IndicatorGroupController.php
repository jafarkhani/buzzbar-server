<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

namespace ProfPortfolio\Controllers;

use Slim\Container;
use Utils\BaseController;

use ProfPortfolio\Models\IndicatorGroups;

class IndicatorGroupController extends BaseController{

    protected $container;

    public function __construct(Container $container){
		
        parent::__construct($container);
		$this->model = new IndicatorGroups();
        
    }

} //End of class GroupController