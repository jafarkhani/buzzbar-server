<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class ReviewStudyField extends BaseClass{

    const TableName = "TPF_ReviewStudyFields";
    const TableKey = "RecID";
    const ClassDesc = "تدوین و بازنگری سرفصل دروس";
    static $SearchField = "";
    static $domains = ['TPF_RSF_TY'=>"ReviewType"];
    static $FK = ["FldCode"=>[],"LanguageID"=>["type"=>"select"],"EduSecCode"=>["type"=>"select"]];

    public $RecID;
    public $PersonID;
    public $ReviewType;
    public $FldCode;
    public $name;
    public $LanguageID;
    public $EduSecCode;
    public $definition;
    public $target;
    public $necessity;
    public $ability;
    public $duration;
    public $rules;
    public $description;
    public $ApprovalDate;
    public $grade;
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
        $this->ReviewType  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->FldCode =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->name  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LanguageID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->EduSecCode =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->definition  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->target =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->necessity =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->ability =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->duration =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->rules =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->description =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->ApprovalDate = DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->grade =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>