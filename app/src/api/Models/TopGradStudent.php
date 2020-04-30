<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class TopGradStudent extends BaseClass{

    const TableName = "TPF_TopGradStudents";
    const TableKey = "RecID";
    const ClassDesc = "دانش اموخته برجسته";
    static $SearchField = "";
    static $domains = ['TPF_TS_ACTIVITY_TY'=>"ActivityType"];
    static $FK = ["StNo"=>[]];

    public $RecID;
    public $PersonID;
    public $StNo;
    public $title;
    public $ActivityType;
    public $ActivityDate;
    public $url;
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
        $this->StNo =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->title =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->description =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->ActivityType   =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->ActivityDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->url  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>