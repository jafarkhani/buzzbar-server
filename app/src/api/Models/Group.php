<?php
/*
 * Author: M.Fattahi
 * Date: 1399-02
*/

namespace Api\Models;

use DataMember;
use Api\Models\BaseClass;
use EntityClass;
use InputValidation;

class Group extends BaseClass {

    const TableName = "groups";
    const TableKey = "GroupID";
    const ClassDesc = "گروه آیتم های کارنما";

    static $domains = [];
    static $FK = [];

    public $GroupID;
    public $SuperGroupID;
    public $GroupPTitle;
    public $GroupETitle;
    public $GroupOrder;
    public $LogID;
    public $RecordStatus;

    public function getStatic($name){
        return self::$$name;
    }

    /** 
     * Group constructor.
     * @param array $headerInfo
     * @param null $id
     */
    public function __construct($headerInfo = array(), $id =null){

        $this->GroupID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->SuperGroupID= DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->GroupPTitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->GroupETitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->GroupOrder= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LogID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        parent::__construct($headerInfo,$id);

    }
    
}//End of class Group