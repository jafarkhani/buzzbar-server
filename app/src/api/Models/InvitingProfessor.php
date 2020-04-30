<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class InvitingProfessor extends BaseClass{

    const TableName = "TPF_INT_InvitingProfessors";
    const TableKey = "RecID";
    const ClassDesc = "همکاریهای بین المللی - دعوت از اساتید";
    static $SearchField = "";
    static $domains = ['TPF_INT_IP_HINDEX'=>'HIndexType',"TPF_INT_IP_AT"=>'ActivityType'];
    static $FK = ["EduGrpCode"=>[],"LesCode"=>[],"semester"=>["type"=>"select"]];

    public $RecID;
    public $PersonID;
    public $PFName;
    public $PLName;
    public $university;
    public $HIndexType;
    public $EduGrpCode;
    public $LesCode;
    public $EduYear;
    public $semester;
    public $StayingTime;
    public $ActivityType;
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
        $this->PFName =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->PLName =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->university =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->HIndexType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->EduGrpCode =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LesCode =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->EduYear =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->semester =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->StayingTime =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->ActivityType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->description =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>