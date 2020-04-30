<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class EducationalAssistant extends BaseClass{

    const TableName = "TPF_EducationalAssistants";
    const TableKey = "RecID";
    const ClassDesc = "دستیار آموزشی";
    static $SearchField = "";
    static $domains = [];
    static $FK = ["StNo"=>[],"LesID"=>[]];

    public $RecID;
    public $PersonID;
    public $StNo;
    public $LesID;
    public $ContractDate;
    public $ContractDuration;
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
        $this->StNo  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LesID  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->ContractDuration  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->ContractDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>