<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class DispatchingForm extends BaseClass{

    const TableName = "TPF_INT_DispatchingForms";
    const TableKey = "RecID";
    const ClassDesc = "همکاریهای بین المللی - اعزام";
    static $SearchField = "";
    static $domains = ['TPF_INT_DISPATCH_GR'=>"DispatchGroup",'TPF_INT_ACTIVITY_TY'=>"ActivityType"];
    static $FK = [];

    public $RecID;
    public $PersonID;
    public $title;
    public $PFName;
    public $PLName;
    public $DispatchGroup;
    public $ActivityType;
    public $DispatchDate;
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
        $this->PLName =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->DispatchGroup =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->ActivityType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->DispatchDate =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>