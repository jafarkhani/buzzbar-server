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
		
		// check for uniquness of year and term
		$dt = parent::runquery("select * from FormHeaders where FormYear=? and FormSemester=?",array(
			$this->FormYear , $this->FormSemester
		));
		if(count($dt) > 0){
			\ExceptionHandler::PushException("در این سال و ماه فرم ایجاد شده است");
			return false;
		}
		
		$this->ComputeDate = PDONOW;
		$this->RegPersonID = parent::$headerInfo[HeaderKey::PERSON_ID];
		return true;
	}
	
	/**
	 * list of professors that portfolio has to be computed for them
	 */
	static function GetRelatedProfs(){
		return parent::runquery("
			select * from hrmstotal.persons where person_type=1 limit 2
		");
	}
}