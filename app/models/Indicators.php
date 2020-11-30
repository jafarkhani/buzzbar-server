<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

namespace ProfPortfolio\Models;

use DataMember;

class Indicators extends \OperationClass {

    const TableName = "indicators";
    const TableKey = "IndicatorID";

    public $IndicatorID;
    public $GroupID;
    public $IndicatorPTitle;
    public $IndicatorETitle;
    public $StandardValue;
	public $ScoreUnit;
	public $ScoreThreshold;
	public $MaxScore;
    public $StandardMaxScore;
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

        $this->DT_GroupID = DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->DT_DeputyID = DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->DT_GroupPName = DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->DT_GroupEName = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->DT_IsActive = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
		
        parent::__construct($id);
    }
 
	static public function Get($where = '', $whereParams = array(), $pdo = null) {
		
		return parent::runquery_fetchMode("
			select i.*,
				g.GroupPName
			from indicators i
				join IndicatorGroups g using(GroupID)
			where 1=1 " . $where, $whereParams, $pdo);		
	}
	
	public function createWhere(&$where, &$params, $search){
		
		$where .= " AND (
			GroupPName like :search
			or 
			IndicatorPTitle; like :search
			or
			IndicatorETitle like :search
		)";
		$params[":search"] = "%" . $search . "%";
	}

	public function Remove($pdo = null) {
		
		$dt = Form::Get(" AND GroupID=?", array($this->GroupID));
		if($dt->rowCount() > 0){
			$this->IsActive = "NO";
			return $this->Edit($pdo);			
		}
		
		return parent::Remove($pdo);
	}
}