<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class lecture extends BaseClass{

    const TableName = "TPF_lectures";
    const TableKey = "RecID";
    const ClassDesc = "سخنرانی علمی";
    static $SearchField = "title";
    static $domains = ["TPF_LE_CTY"=>"CooperationType","TPF_LE_TY"=>"type","TPF_LE_LEVEL"=>'level'];
    static $FK = [];

    public $RecID;
    public $PersonID;
    public $title;
    public $location;
    public $CooperationType;
    public $type;
    public $level;
    public $url;
    public $LectureDate;
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
        $this->title  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->location  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->CooperationType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->type =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->level =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->url  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LectureDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->description  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>