<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

namespace ProfPortfolio\Controllers;

use Slim\Container;
use Utils\BaseController;

use ProfPortfolio\Models\IndicatorGroup;

class IndicatorGroupController extends BaseController{

    protected $container;

    public function __construct(Container $container){
		
        parent::__construct($container);
		$this->model = new IndicatorGroup();
        
    }

} 