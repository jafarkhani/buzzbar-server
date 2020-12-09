<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

namespace ProfPortfolio\Models;

use DataMember;
use ProfPortfolio\Models\FormItems;

class Indicator extends \OperationClass {

    const TableName = "indicators";
    const TableKey = "IndicatorID";

    public $IndicatorID;
    public $GroupID;
    public $IndicatorPTitle;
    public $IndicatorETitle;
    public $StandardValue;
	public $ScoreUnit;
	public $ScoreCoef;
	public $MaxScore;
	public $DeputyScore;
    public $PercentScore;
    public $objective;
    public $ScoreReference;
    public $ItemOrder;
    public $IsActive;
    public $description;
    public $ApiUrl;
    public $ApiObjectID;
    public $ApiObjectID2;
    public $ApiObjectID3;
    public $ApiTitleField;
    public $ApiCountField;
    public $ApiStartDateField;
    public $ApiEndDateField;
	
    public function __construct($id =null){

		$this->DT_IndicatorID = DataMember::CreateDMA(DataMember::Pattern_Num);
		$this->DT_GroupID = DataMember::CreateDMA(DataMember::Pattern_Num);
		$this->DT_IndicatorPTitle = DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
		$this->DT_IndicatorETitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
		$this->DT_StandardValue = DataMember::CreateDMA(DataMember::Pattern_Num);
		$this->DT_ScoreUnit = DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
		$this->DT_ScoreCoef = DataMember::CreateDMA(DataMember::Pattern_Num);
		$this->DT_MaxScore = DataMember::CreateDMA(DataMember::Pattern_Num);
		$this->DT_DeputyScore = DataMember::CreateDMA(DataMember::Pattern_Num);
		$this->DT_PercentScore = DataMember::CreateDMA(DataMember::Pattern_Num);
		$this->DT_objective = DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
		$this->DT_ScoreReference = DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
		$this->DT_ItemOrder = DataMember::CreateDMA(DataMember::Pattern_Num);
		$this->DT_IsActive = DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
		$this->DT_description = DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
		
        parent::__construct($id);
    }
 
	static public function Get($where = '', $whereParams = array(), $pdo = null) {
		
		return parent::runquery_fetchMode("
			select i.*,
				g.GroupPName
			from indicators i
				join IndicatorGroups g using(GroupID)
			where i.IsActive='YES' " . $where, $whereParams, $pdo);		
	}
	
	public function createWhere(&$where, &$params, $QueryParams){
		
		if(!empty($QueryParams["GroupID"])){
			$where .= " AND GroupID=:groupid";
			$params[":groupid"] = $QueryParams["GroupID"];
		}
		
		if(!empty($QueryParams["search"])){
			$where .= " AND (
				GroupPName like :search
				or 
				IndicatorPTitle; like :search
				or
				IndicatorETitle like :search
			)";
			$params[":search"] = "%" . $QueryParams["search"] . "%";
		}
	}

	public function Remove($pdo = null) {
		
		$dt = FormItems::Get(" AND IndicatorID=?", array($this->IndicatorID));
		if($dt->rowCount() > 0){
			$this->IsActive = "NO";
			return $this->Edit($pdo);			
		}
		
		return parent::Remove($pdo);
	}
}