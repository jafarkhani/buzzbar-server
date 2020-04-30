<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class DualDegree extends BaseClass{

    const TableName = "TPF_INT_DualDegrees";
    const TableKey = "RecID";
    const ClassDesc = "همکاریهای بین المللی - مدرک دوگانه";
    static $SearchField = "";
    static $domains = [];
    static $FK = ["EduSecCode"=>["type"=>"select"]];

    public $RecID;
    public $PersonID;
    public $title;
    public $EduSecCode;
    public $PFieldName;
    public $ImpDate;
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
        $this->title =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->EduSecCode =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->PFieldName =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->ImpDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>