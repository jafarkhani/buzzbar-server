<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

namespace App\Controllers;

use Slim\Container;
use Utils\BaseController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use ResponseHelper;
use League\Csv\Writer;

class PlayerController {

    protected $container;

    public function __construct(Container $container){
		
    }
	
	public function AddScore(Request $request, Response $response, array $args){
		
		return "----";
		$writer = Writer::createFromPath("scores", 'w+');
		$writer->setDelimiter(";");
		$writer->setNewline("\r\n");
		
		$params = $request->getQueryParams();
		$writer->insertOne(array(
			$params["player"],
			$params["score"]
		));
		
		return ResponseHelper::createSuccessfulResponse($response, $data);
	}

} //End of class GroupController