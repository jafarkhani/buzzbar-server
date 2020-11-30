<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

namespace ProfPortfolio\Models;

use DataMember;
use HeaderKey;

class FormItems extends \OperationClass {

    const TableName = "FormItems";
    const TableKey = "ItemID";

	public $ItemID;
    public $FormID;
    public $IndicatorID;
    public $ObjectID;
    public $ObjectID2;
	public $ObjectID3;
    public $ObjectTitle;
	public $ObjectStartDate;
	public $ObjectEndDate;
	
    public function __construct($id =null){

        $this->DT_FormID = DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->DT_FormYear = DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->DT_FormSemester = DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->DT_ComputeDate = DataMember::CreateDMA(DataMember::Pattern_DateTime);
		$this->DT_RegPersonID = DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->DT_IsActive = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
		
        parent::__construct($id);
    }
    
	static public function Get($where = '', $whereParams = array(), $pdo = null) {
		
		return parent::runquery_fetchMode("
			select fi.*,
				fi.IndicatorPTitle
			from FormItems fi
				join indicators i using(IndicatorID)
			where 1=1 " . $where, $whereParams, $pdo);
		
	}
	
	public function createWhere(&$where, &$params, $search){
		
		$where .= " AND (
			IndicatorPTitle like :search
			or 
			ObjectTitle like :search
		)";
		$params[":search"] = "%" . $search . "%";
	}
	
}