<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class ReviewCourseSyllabus extends BaseClass{



    const TableName = "TPF_ReviewCourseSyllabus";
    const TableKey = "RecID";
    const ClassDesc = "درسنامه دروس بازنگری شده";
    static $SearchField = "";
    static $domains = [];
    static $FK = ["LesCode"=>[],"LanguageID"=>["type"=>"select"],"semester"=>["type"=>"select"]];

    public $RecID;
    public $PersonID;
    public $title;
    public $LesCode;
    public $EduYear;
    public $semester;
    public $location;
    public $pages;
    public $LanguageID;
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
        $this->description =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LesCode  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->EduYear  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->semester  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->location =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->pages  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LanguageID  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>