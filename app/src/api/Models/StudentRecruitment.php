<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class StudentRecruitment extends BaseClass{

    const TableName = "TPF_INT_StudentRecruitments";
    const TableKey = "RecID";
    const ClassDesc = "همکاریهای بین المللی - جذب و پذیرش دانشجو (در قالب بورسیه دانشگاه و وزارت)";
    static $SearchField = "";
    static $domains = [];
    static $FK = ["StNo"=>[]];

    public $RecID;
    public $PersonID;
    public $StNo;
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
        $this->StNo = DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>