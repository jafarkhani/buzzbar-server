<?php
//----------------------------
//developer   : Sh.Jafarkhani
//date        : 2020-11
//----------------------------

namespace ProfPortfolio\Models;

use DataMember;
use HeaderKey;

class FormHeader extends \OperationClass {

    const TableName = "FormHeaders";
    const TableKey = "FormID";

    public $FormID;
    public $FormYear;
    public $FormSemester;
    public $ComputeDate;
	public $RegPersonID;
    public $IsActive;
	
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
			select f.*,
				concat(p.pfname,' ',p.plname) RegPersonFullname,
				f1.title FormStatusDesc
			from FormHeaders f
				left join hrmstotal.persons p on(p.PersonID=f.RegPersonID)
				join BasicInfo f1 on(f1.TypeID=".TYPEID_FormHeaders_status." AND f1.InfoID=f.StatusID)
			where 1=1 " . $where, $whereParams, $pdo);
		
	}
	
	public function createWhere(&$where, &$params, $search){
		
		$where .= " AND (
			concat(p.pfname,' ',p.plname) like :search
			or 
			f1.title like :search
			or 
			FormYear like :search
		)";
		$params[":search"] = "%" . $search . "%";
	}
	
	public function BeforeAddTrigger($pdo = null){
		
		$this->ComputeDate = PDONOW;
		$this->RegPersonID = parent::$headerInfo[HeaderKey::PERSON_ID];
		return true;
	}
}