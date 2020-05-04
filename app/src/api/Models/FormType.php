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

class FormType extends BaseClass {

    const TableName = "FormTypes";
    const TableKey = "FormType";
    const ClassDesc = "نوع های فرم";
    static $domains = [];
    static $FK = [];

    public $FormType;
    public $FormTypePTitle;
    public $FormTypeETitle;
    public $LogID;
    public $RecordStatus;

    public function getStatic($name){
        return self::$$name;
    }

    /** 
     * FormType constructor.
     * @param array $headerInfo
     * @param null $id
     */
    public function __construct($headerInfo = array(), $id =null){

        $this->FormType= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->FormTypePTitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->FormTypeETitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->LogID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        parent::__construct($headerInfo,$id);

    }
    
}//End of class FormType