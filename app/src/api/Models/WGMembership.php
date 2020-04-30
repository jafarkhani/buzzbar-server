<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class WGMembership extends BaseClass{

    const TableName = "TPF_WGMemberships";
    const TableKey = "RecID";
    const ClassDesc = "عضویت در کارگروه";
    static $SearchField = "title";
    static $domains = ["TPF_WGM_LEVEL"=>"level"];
    static $FK = [];

    public $RecID;
    public $PersonID;
    public $title;
    public $level;
    public $StartDate;
    public $EndDate;
    public $description;
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
        $this->level =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->StartDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->EndDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->description  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>