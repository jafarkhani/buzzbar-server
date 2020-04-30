<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class LanguageCert extends BaseClass{



    const TableName = "TPF_LanguageCerts";
    const TableKey = "RecID";
    const ClassDesc = "مدرک زبانی";
    static $SearchField = "";
    static $domains = ["TPF_LC_TY"=>"CertType"];
    static $FK = ["LanguageID"=>["type"=>"select"]];

    public $RecID;
    public $PersonID;
    public $LanguageID;
    public $CertType;
    public $grade;
    public $CertDate;
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
        $this->LanguageID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->CertType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->grade =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->CertDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>