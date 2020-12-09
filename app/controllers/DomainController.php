<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

namespace ProfPortfolio\Controllers;

use Slim\Container;
use Utils\BaseController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use ResponseHelper;

use ProfPortfolio\Models\Domains;

class DomainController extends BaseController{

    protected $container;

    public function __construct(Container $container){
		
        parent::__construct($container);
		$this->model = new Domains();        
    }
	
	public function selectDeputies(Request $request, Response $response, array $args){
		
		$where = "";
		$params = [];
		
		$params = $request->getQueryParams();
		if(!empty($params["search"])){
			$where = " AND InfoTitle like :search";
			$params[":search"] = "%" . $params["search"] . "%";
		}
		
		if(!empty($args['id'])){
			$where = " AND InfoID = :id";
			$params[":id"] = (int)$args['id'];
		}
		
		$data = $this->model
				->Get(" AND TypeID=1 " . $where, $params)
				->fetchAll();
		
		return ResponseHelper::createSuccessfulResponse($response, $data);
	}

} //End of class GroupController