<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class TournamentSup extends BaseClass{

    const TableName = "TPF_TournamentSups";
    const TableKey = "RecID";
    const ClassDesc = "سرپرستی مسابقات";
    static $SearchField = "title";
    static $domains = [];
    static $FK = [];

    public $RecID;
    public $PersonID;
    public $title;
    public $StartDate;
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
        $this->StartDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->description  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>