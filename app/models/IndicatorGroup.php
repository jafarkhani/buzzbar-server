<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

namespace ProfPortfolio\Models;

use DataMember;

class IndicatorGroup extends \OperationClass {

    const TableName = "IndicatorGroups";
    const TableKey = "GroupID";

    public $GroupID;
    public $DeputyID;
    public $GroupPName;
    public $GroupEName;
    public $IsActive;
	
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
			select g.*,
				f1.InfoTitle DeputyDesc
			from IndicatorGroups g
				join BasicInfo f1 on(f1.TypeID=".TYPEID_indicator_deputies." AND f1.InfoID=g.DeputyID)
			where g.IsActive='YES' " . $where, $whereParams, $pdo);
		
	}
	
	public function createWhere(&$where, &$params, $QueryParams){
		
		if(!empty($QueryParams["search"]))
		{
			$where .= " AND (
				f1.InfoTitle like :search
				or 
				GroupPName like :search
				or
				GroupEName like :search
			)";
			$params[":search"] = "%" . $QueryParams["search"] . "%";
		}
	}
	
	public function Remove($pdo = null) {
		
		$dt = Indicators::Get(" AND GroupID=?", array($this->GroupID));
		if($dt->rowCount() > 0){
			$this->IsActive = "NO";
			return $this->Edit($pdo);			
		}
		
		return parent::Remove($pdo);
	}
}