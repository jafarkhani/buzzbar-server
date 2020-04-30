<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class TrainingPlan extends BaseClass{


    const TableName = "TPF_TrainingPlans";
    const TableKey = "RecID";
    const ClassDesc = "طرح اموزشی ";
    static $SearchField = "";
    static $domains = ['TPF_TP_PLAN_TY'=>"PlanType"];
    static $FK = [];

    public $RecID;
    public $PersonID;
    public $title;
    public $PlanType;
    public $StartDate;
    public $EndDate;
    public $LogID;
    public $RecordStatus;

    public function getStatic($name){
        return self::$$name;
    }

    /**
     * SuperGroup constructor.
     * @param array $headerInfo
     * @param null $id
     */
    public function __construct($headerInfo = array(), $id =null)
    {

        $this->RecID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->PersonID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->title  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->PlanType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->StartDate =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->EndDate =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>