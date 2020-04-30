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

class Groups extends BaseClass {

    const TableName = "TPF_Groups";
    const TableKey = "GroupID";
    const ClassDesc = "گروه آیتم های کارنما";

    public $GroupID;
    public $SuperGroupID;
    public $GroupPName;
    public $GroupEName;
    public $ScoreAnnualThreshold;
    public $GroupOrder;
    public $LogID;
    public $RecordStatus;

    public function __construct($headerInfo = array(), $id =null){

        $this->GroupID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->SuperGroupID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->GroupPName = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->GroupEName = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->ScoreAnnualThreshold = DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->GroupOrder= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LogID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        parent::__construct($headerInfo,$id);

    }
    public function GetAll($SuperGroupID){
        $mysql = parent::getReportDBConnection();
        echo $query = "SELECT * FROM TPF_Groups where RecordStatus<>'DELETED' and SuperGroupID=:SuperGroupID order by GroupOrder";
        $mysql->Prepare($query);
        $objArray = $mysql->ExecuteStatement(array(":SuperGroupID"=>$SuperGroupID));
        $objArray = $objArray->fetchAll();print_r($objArray);
        InputValidation::ArrayEncoding($objArray);
        return $objArray;
    }
}//End of class Groups