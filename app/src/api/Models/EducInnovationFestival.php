<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class EducInnovationFestival extends BaseClass{


    const TableName = "TPF_EducInnovationFestivals";
    const TableKey = "RecID";
    const ClassDesc = "نوآوری آموزشی در قالب جشنواره";
    static $SearchField = "";
    static $domains = ["TPF_FESTIVAL_TY"=>"FestivalType" , "TPF_AWARD_TY"=>"AwardType"];
    static $FK = [];

    public $RecID;
    public $PersonID;
    public $title;
    public $FestivalTitle;
    public $FestivalType;
    public $FestivalDate;
    public $AwardType;
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
        $this->title =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->FestivalTitle =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->FestivalType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->FestivalDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->AwardType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->description =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>