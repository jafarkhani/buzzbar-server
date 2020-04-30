<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class OtherActivity extends BaseClass{

    const TableName = "TPF_OtherActivities";
    const TableKey = "RecID";
    const ClassDesc = "سایر فعالیت ها";
    static $SearchField = "";
    static $domains = ['TPF_OA_AI'=>'ActivityID'];
    static $FK = [];

    public $RecID;
    public $PersonID;
    public $title;
    public $url;
    public $ActivityID;
    public $ActivityDate;
    public $hours;
    public $days;
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
        $this->url =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->ActivityID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->ActivityDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->hours =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->days =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->description =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>