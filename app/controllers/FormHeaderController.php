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
use ReportGenerator;

use ProfPortfolio\Models\FormHeader;
use ProfPortfolio\Models\Indicator;
use ProfPortfolio\Models\FormItems;

class FormHeaderController extends BaseController{

    protected $container;

    function __construct(Container $container){
		
        parent::__construct($container);
		$this->model = new FormHeader();
        
    }

	function compute(Request $request, Response $response, array $args){
		
		$params = $request->getQueryParams();
		$FormID = (int)$params['FormID'];
		
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
				$obj->score = round($indic["PercentScore"]*$obj->ObjectCount/$indic["ScoreCoef"],2);
				if(!$obj->Add()){
					$errors[] = \ExceptionHandler::GetExceptionsToString();
				}
			}
		}
		
		return ResponseHelper::createSuccessfulResponse($response, $errors);
	}
	
	function IndicatorCompute(Request $request, Response $response, array $args){
		
		$params = $request->getQueryParams();
		$FormID = (int)$params['FormID'];
		$IndicatorID = (int)$params['IndicatorID'];
		
		$formObj = new FormHeader($FormID);
		if(empty($formObj->FormID)){
			return ResponseHelper::createFailureResponseByException($response, "کد فرم نامعتبر می باشد");
		}
		
		if(!$formObj->RemoveAllItems($IndicatorID)){
			return ResponseHelper::createFailureResponseByException($response, \ExceptionHandler::GetExceptionsToString());
		}
				
		$persons = FormHeader::GetRelatedProfs();
		$http = new HttpResponse($this->container["settings"]["hashSalt"]);
		$indicators = Indicator::Get(" AND IndicatorID=?", array($IndicatorID))->fetchAll();
		
		$FromDate = DateModules::shamsi_to_miladi($formObj->FormYear . 
				($formObj->FormSemester == "1" ? "-12-01" : "-06-01"));
		$FromDate = "1880-01-01"; // we compute all data in for first portfolio
		$EndDate = DateModules::Now();
		
		$errors = [];		
		if(empty($indic["ApiUrl"])){
			return ResponseHelper::createFailureResponseByException($response, "empty ApiUrl");
		}

		$http->CallService(HttpResponse::METHOD_GET, $indic["ApiUrl"],[
			$indic["ApiStartDateField"] => $FromDate,
			$indic["ApiEndDateField"]  => $EndDate
		]);

		if(!$http->isOk()){	
			return ResponseHelper::createFailureResponseByException($response, $http->getMessage());
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
			$obj->score = round($indic["PercentScore"]*$obj->ObjectCount/$indic["ScoreCoef"],2);
			if(!$obj->Add()){
				$errors[] = \ExceptionHandler::GetExceptionsToString();
			}
		}
		
		if($errors == [])
			return ResponseHelper::createSuccessfulResponse($response, $errors);
		
		return ResponseHelper::createFailureResponseByException($response, implode("<br>", $errors));
	}
	
	function Report_FormDetails(Request $request, Response $response, array $args){
		
		$params = $request->getQueryParams();
		$FormID = (int)$params['FormID'];
		
		$formObj = new FormHeader($FormID);
		if(empty($formObj->FormID)){
			return ResponseHelper::createFailureResponseByException($response, "کد فرم نامعتبر می باشد");
		}
		
		$dt = \PdoDataAccess::runquery("
			select 
				FormID,
				PersonID,
				concat(pfname,' ',plname) fullname,
				bf1.InfoTitle DeputyName,
				DeputyID,
				sum(if(DeputyID=1, fi.score, 0)) as EducScores,
				sum(if(DeputyID=2, fi.score, 0)) as ReseachScores,
				sum(if(DeputyID=3, fi.score, 0)) as CultureScores,
				sum(if(DeputyID=4, fi.score, 0)) as ExecutiveScores					

			from FormItems fi
				join hrmstotal.persons p using(PersoniD)
				join indicators i using(IndicatorID)
				join IndicatorGroups g using(GroupID)
				join BasicInfo bf1 on(bf1.TypeID=" . TYPEID_indicator_deputies . " AND bf1.InfoID=g.DeputyID)
			where FormID=?
			Group by DeputyID,PersonID", array($FormID));

		$rpt = new ReportGenerator();
		$rpt->mysql_resource = $dt;

		$rpt->addColumn("نام و نام خانوادگی", "fullname", function($row, $value){
			return "<a target='_blank' href='PersonDetails.php?FormID=" . $row["FormID"] . 
					"&PersonID=" . $row["PersonID"] . "'>" . $value . "</a>"; 
		});
		//$rpt->addColumn("گروه آموزشی", "");
		
		$col = $rpt->addColumn("امتیاز آموزشی", "EducScores");
		$col = $rpt->addColumn("امتیاز پژوهشی", "ReseachScores");
		$col = $rpt->addColumn("امتیاز فرهنگی", "CultureScores");
		$col = $rpt->addColumn("امتیاز اجرایی", "ExecutiveScores");

		$rpt->header = "گزارش جامع کارنمای اعضای هیئت علمی به تفکیک گروه آموزشی" . "<br>" .
				"سال تحصیلی " . $formObj->FormYear . "<br>" .
				"ترم تحصیلی " . $formObj->FormSemester;
		
		$report = $rpt->generateReport();
		
		return \ResponseHelper::createSuccessfulResponse($response, $report);
	}
	
	function Report_PersonDetails(Request $request, Response $response, array $args){
		
		$params = $request->getQueryParams();
		$FormID = (int)$params['FormID'];
		$PersonID = (int)$params['PersonID'];
		
		$formObj = new FormHeader($FormID);
		
		$dt = \PdoDataAccess::runquery("
			select 
				concat(pfname,' ',plname) fullname,
				bf1.InfoTitle DeputyName,
				GroupPName,
				IndicatorPTitle,
				ScoreUnit,
				ScoreCoef,
				PercentScore,
				ObjectTitle,
				ObjectStartDate,
				ObjectEndDate,
				ObjectCount,
				fi.score

			from FormItems fi
				join hrmstotal.persons p using(PersoniD)
				join indicators i using(IndicatorID)
				join IndicatorGroups g using(GroupID)
				join BasicInfo bf1 on(bf1.TypeID=" . TYPEID_indicator_deputies . " AND bf1.InfoID=g.DeputyID)
			where FormID=? AND fi.PersonID=?
			Order by DeputyID,GroupPName,IndicatorPTitle", array($FormID, $PersonID));
		
		if(count($dt) == 0){
			return \ResponseHelper::createSuccessfulResponse($response, "گزارش فاقد اطلاعات می باشد");
		}
			
		$rpt = new ReportGenerator();
		$rpt->mysql_resource = $dt;
		
		$col = $rpt->addColumn("حوزه", "DeputyName");
		$col->rowspanByFields = ["DeputyName"];
		
		$col = $rpt->addColumn("گروه شاخص", "GroupPName");
		$col->rowspanByFields = ["DeputyName", "GroupPName"];
				
		$col = $rpt->addColumn("شاخص", "IndicatorPTitle");
		$col->rowspanByFields = ["DeputyName", "GroupPName","IndicatorPTitle"];
		
		$col = $rpt->addColumn("عنوان", "ObjectTitle");
		$col->GroupHeader = "آیتم اطلاعاتی";
		
		$col = $rpt->addColumn("تاریخ شروع", "ObjectStartDate", "ReportDateRender");
		$col->GroupHeader = "آیتم اطلاعاتی";
		
		$col = $rpt->addColumn("تاریخ پایان", "ObjectEndDate", "ReportDateRender");
		$col->GroupHeader = "آیتم اطلاعاتی";
		
		$col = $rpt->addColumn("مقیاس", "ScoreUnit");
		$col->GroupHeader = "آیتم اطلاعاتی";
		
		$col = $rpt->addColumn("مقدار", "ObjectCount");
		$col->GroupHeader = "آیتم اطلاعاتی";
		
		$col = $rpt->addColumn("ضریب امتیاز", "ScoreCoef");
		$col = $rpt->addColumn("امتیاز در بازه 0-100", "PercentScore");
		
		
		$col = $rpt->addColumn("امتیاز", "score");
		$col->EnableSummary();

		$rpt->header = "گزارش جامع کارنمای " . $dt[0]["fullname"] . "<br>" .
				"سال تحصیلی " . $formObj->FormYear . "<br>" .
				"ترم تحصیلی " . $formObj->FormSemester;
		
		$report = $rpt->generateReport();
		
		return \ResponseHelper::createSuccessfulResponse($response, $report);
	}
}