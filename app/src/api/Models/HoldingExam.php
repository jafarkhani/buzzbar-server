<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class HoldingExam extends BaseClass{


    const TableName = "TPF_HoldingExams";
    const TableKey = "RecID";
    const ClassDesc = "سنجش و اندازه گیری";
    static $SearchField = "";
    static $domains = ['TPF_HE_EXAM_TY'=>"ExamType","TPF_HE_EXAM_CO_TY"=>"CooperationType"];
    static $FK = ["EduSecCode"=>["type"=>"select"],"semester"=>["type"=>"select"]];

    public $RecID;
    public $PersonID;
    public $title;
    public $ExamType;
    public $EduYear;
    public $semester;
    public $EduSecCode;
    public $CooperationType;
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
        $this->ExamType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->EduYear =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->semester =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->CooperationType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->EduSecCode =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>