<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

namespace ProfPortfolio\Controllers;

use Slim\Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Utils\BaseController;
use ResponseHelper;
use HttpResponse;
use DateModules;

use ProfPortfolio\Models\FormHeader;
use ProfPortfolio\Models\Indicator;
use ProfPortfolio\Models\FormItems;

class FormHeaderController extends BaseController{

    protected $container;

    public function __construct(Container $container){
		
        parent::__construct($container);
		$this->model = new FormHeader();
        
    }

	public function compute(Request $request, Response $response, array $args){
		
		$FormID = (int)$args['id'];
		
		$formObj = new FormHeader($FormID);
		if(empty($formObj->FormID)){
			return ResponseHelper::createFailureResponseByException($response, "کد فرم نامعتبر می باشد");
		}
		
		if(!$formObj->RemoveAllItems()){
			return ResponseHelper::createFailureResponseByException($response, \ExceptionHandler::GetExceptionsToString());
		}
				
		$persons = FormHeader::GetRelatedProfs();
		$http = new HttpResponse($this->container["settings"]["hashSalt"]);
		$indicators = Indicator::Get()->fetchAll();
		
		$FromDate = DateModules::shamsi_to_miladi($formObj->FormYear . 
				($formObj->FormSemester == "1" ? "-12-01" : "-06-01"));
		$FromDate = "1880-01-01"; // we compute all data in for first portfolio
		$EndDate = DateModules::Now();
		
		$errors = [];		
		foreach($indicators as $indic){
			
			if(empty($indic["ApiUrl"]))
				continue;
		
			$http->CallService(HttpResponse::METHOD_GET, $indic["ApiUrl"],[
				$indic["ApiStartDateField"] => $FromDate,
				$indic["ApiEndDateField"]  => $EndDate
			]);
			
			if(!$http->isOk()){	
				$errors[] = $http->getMessage();
				continue;
			}
			
			$result = $http->getResult();
			foreach($result as $data){
				
				if(!isset($persons[ $data->PersonID ]))
					continue;
				
				$obj = new FormItems();
				$obj->FormID = $formObj->FormID;
				$obj->IndicatorID = $indic["IndicatorID"];
				$obj->PersonID = $data->PersonID;
				$obj->ObjectID = $data->{ $indic["ApiObjectID"] };
				$obj->ObjectID2 = !empty($indic["ApiObjectID2"]) ? $data->{$indic["ApiObjectID2"]} : PDONULL;
				$obj->ObjectID3 = !empty($indic["ApiObjectID3"]) ? $data->{$indic["ApiObjectID3"]} : PDONULL;
				$obj->ObjectTitle = $data->{ $indic["ApiTitleField"] };
				$obj->ObjectStartDate = $data->{ $indic["ApiStartDateField"] };
				$obj->ObjectEndDate = $data->{ $indic["ApiEndDateField"] };
				$obj->ObjectCount = !empty($indic["ApiCountField"]) ? $data->{ $indic["ApiCountField"] } : 1;
				$obj->score = $indic["PercentScore"]*$obj->ObjectCount;
				if(!$obj->Add()){
					$errors[] = \ExceptionHandler::GetExceptionsToString();
				}
			}
		}
		
		return ResponseHelper::createSuccessfulResponse($response, $errors);
	}
}