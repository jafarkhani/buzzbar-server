<?php
/**
 * Author: rmahdizadeh
 * Date: 1398-05-05
 */
namespace ProfPortfolio\Controllers;

use Slim\Container;
use Utils\BaseController;
use ResponseHelper;

use ProfPortfolio\Models\Domains;

class DomainController extends BaseController{

    protected $container;

    public function __construct(Container $container){
		
        parent::__construct($container);
		$this->model = new Domains();        
    }
	
	public function selectDeputies(){
		
		$data = $this->model
				->Get(" AND TypeID=1")
				->fetchAll();
		
		return ResponseHelper::createSuccessfulResponse($response, $data);
	}

} //End of class GroupController