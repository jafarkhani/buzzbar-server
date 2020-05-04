<?php
/*
 * Author: rmahdizadeh
 * Date: 1398-05-05
*/

namespace Api\Models;

use DataMember;
use Api\Models\BaseClass;
use EntityClass;
use InputValidation;

class Item extends BaseClass {

    const TableName = "items";
    const TableKey = "ItemID";
    const ClassDesc = "شاخص های فرم کارنما";
    static $domains = [];
    static $FK = [];

    public $ItemID;
    public $FormType;
    public $GroupID;
    public $ItemPTitle;
    public $ItemETitle;
    public $StandardValue;
    public $ScoreUnit;
    public $ScoreThreshold;
    public $MaxScore;
    public $StandardMaxScore;
    public $objective;
    public $ScoreReference;
    public $ItemOrder;
    public $LogID;
    public $RecordStatus;
    public $ItemDescription;
    
    public function getStatic($name){
        return self::$$name;
    }

    /** 
     * Item constructor.
     * @param array $headerInfo
     * @param null $id
     */
    public function __construct($headerInfo = array(), $id =null){

        $this->ItemID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->FormType= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->GroupID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->ItemPTitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->ItemETitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->StandardValue= DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->ScoreUnit= DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->ScoreThreshold= DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->MaxScore= DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->StandardMaxScore= DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->objective= DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->ScoreReference= DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->ItemOrder= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LogID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->ItemDescription= DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        parent::__construct($headerInfo,$id);

    }
    
}//End of class Item