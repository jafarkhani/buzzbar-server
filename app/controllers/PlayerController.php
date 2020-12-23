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
use League\Csv\Reader;

class PlayerController {

    protected $container;

    public function __construct(Container $container){
		
    }
	
	public function AddScore(Request $request, Response $response, array $args){
		
		try{
			$params = $request->getQueryParams();
			
			$reader = Reader::createFromPath("scores", 'r');
			$reader->setDelimiter(";");					
			$rows = $reader->fetchAll();
			
			$result = [];
			for($i=0; $i<count($rows); $i++){
				if($rows[$i][3] >= $params["score"]){
					$result[] = $rows[$i];
					continue;
				}				
				break;				
			}
			if(count($result) < 10){
				$result[] = [
					$params["name"],
					$params["total"],
					$params["hits"],
					$params["score"]
				];

				while(count($result)< 10 && $i < count($rows)){
					$result[] = $rows[$i];
					$i++;
				}
			}
			
			$writer = Writer::createFromPath("scores", 'w+');
			$writer->setDelimiter(";");
			$writer->setNewline("\n");			
			$writer->insertAll($result);

			return ResponseHelper::createSuccessfulResponse($response);
		}
		catch (Exception $e){
			echo $e->getMessage();
		}
	}

	public function GetScores(Request $request, Response $response, array $args){
		
		try{
			$reader = Reader::createFromPath("scores", 'r');
			$reader->setDelimiter(";");					
			$rows = $reader->fetchAll();
			
			$result = [];
			foreach($rows as $row){
				$result[] = [
					"name" => $row[0],
					"total" => $row[1],
					"hits" => $row[2],
					"score" => $row[3]
				];
			}

			return ResponseHelper::createSuccessfulResponse($response, $result);
		}
		catch (Exception $e){
			throw $e->getMessage();
		}
	}

	
} //End of class GroupController