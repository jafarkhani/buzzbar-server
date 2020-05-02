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
    const TableKey = "FormTypeID";
    const ClassDesc = "گروه آیتم های کارنما";

    public $FormTypeID;
    public $SuperFormTypeID;
    public $FormTypePName;
    public $FormTypeEName;
    public $FormTypeOrder;
    public $LogID;
    public $RecordStatus;

    public function __construct($headerInfo = array(), $id =null){

        $this->FormTypeID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->SuperFormTypeID= DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->FormTypePName = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->FormTypeEName = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->FormTypeOrder= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LogID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        parent::__construct($headerInfo,$id);

    }
    public function GetAll($SuperFormTypeID){
        $mysql = parent::getReportDBConnection();
        echo $query = "SELECT * FROM FormTypes where RecordStatus<>'DELETED' and SuperFormTypeID=:SuperFormTypeID order by FormTypeOrder";
        $mysql->Prepare($query);
        $objArray = $mysql->ExecuteStatement(array(":SuperFormTypeID"=>$SuperFormTypeID));
        $objArray = $objArray->fetchAll();print_r($objArray);
        InputValidation::ArrayEncoding($objArray);
        return $objArray;
    }
}//End of class FormTypes