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
	public $StatusID;
	
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
				f1.InfoTitle FormStatusDesc
			from FormHeaders f
				left join hrmstotal.persons p on(p.PersonID=f.RegPersonID)
				join BasicInfo f1 on(f1.TypeID=".TYPEID_FormHeaders_status." AND f1.InfoID=f.StatusID)
			where 1=1 " . $where, $whereParams, $pdo);
		
	}
	
	public function createWhere(&$where, &$params, $QueryParams){
	
		if(!empty($QueryParams["search"]))
		{
			$where .= " AND (
				concat(p.pfname,' ',p.plname) like :search
				or 
				f1.title like :search
				or 
				FormYear like :search
			)";
			$params[":search"] = "%" . $QueryParams["search"] . "%";
		}
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
		$dt = parent::runquery("select * from hrmstotal.persons where person_type=1");
		
		$result = [];
		foreach($dt as $row){
			$result[ $row["PersonID"] ] = $row;
		}
		return $result;
	}
	
	public function RemoveAllItems($IndicatorID = "", $pdo = null){
		
		if($this->StatusID == FormHeader_Status_confirmed){
			\ExceptionHandler::PushException("حذف محاسبات فرم تایید شده امکان پذیر نمی باشد");
			return false;
		}
		
		if((int)$this->FormID == 0){
			return false;
		}
		
		$query = "delete from FormItems where FormID=?";
		$params = [$this->FormID];
		
		if($IndicatorID != ""){
			$query = " AND IndicatorID=?";
			$params[] = [$IndicatorID];
		}
		
		\PdoDataAccess::runquery($query, $params, $pdo);
		return true;
				
	}
	
}