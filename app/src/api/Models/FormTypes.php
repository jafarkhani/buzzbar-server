<?php
/*
 * Author: rmahdizadeh
 * Date: 1398-05-05
*/

namespace Api\Models;

use DataMember;
use Api\Models\BaseClass;
use EntityClass;
use InputValidation;

class FormTypes extends BaseClass {

    const TableName = "FormTypes";
    const TableKey = "FormType";
    const ClassDesc = "نوع های فرم";

    public $FormType;
    public $FormTypePTitle;
    public $FormTypeETitle;
    public $LogID;
    public $RecordStatus;

    public function __construct($headerInfo = array(), $id =null){

        $this->FormType= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->FormTypePTitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->FormTypeETitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->LogID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        parent::__construct($headerInfo,$id);

    }
    public function GetAll($SuperFormType){
        $mysql = parent::getReportDBConnection();
        echo $query = "SELECT * FROM FormTypes where RecordStatus<>'DELETED' order by FormTypeOrder";
        $mysql->Prepare($query);
        $objArray = $mysql->ExecuteStatement(array());
        $objArray = $objArray->fetchAll();
        InputValidation::ArrayEncoding($objArray);
        return $objArray;
    }
}//End of class FormTypes