<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class SeasonalWorkshop extends BaseClass{

    const TableName = "TPF_SeasonalWorkshops";
    const TableKey = "SeasonalWorkshopID";
    const ClassDesc = "کارگاه / مدرسه فصلی";
    static $SearchField = "title";
    static $domains = ["TPF_SW_TY"=>"type","TPF_SW_ROLE"=>"role","TPF_SW_LEVEL"=>'level',"TPF_SW_AUDIENCE_TY"=>'AudienceType'];
    static $FK = [];

    public $SeasonalWorkshopID;
    public $PersonID ;
    public $title ;
    public $type ;
    public $role ;
    public $level ;
    public $AudienceType ;
    public $StartDate ;
    public $duration ;
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
        $this->SeasonalWorkshopID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->PersonID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->title  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->type  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->role  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->level  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->AudienceType  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->StartDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->duration  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>