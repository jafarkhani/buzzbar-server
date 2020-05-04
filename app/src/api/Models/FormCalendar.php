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

class FormCalendar extends BaseClass {

    const TableName = "FormCalendars";
    const TableKey = "FormCalendarID";
    const ClassDesc = "تقویم های فرم کارنما";
    static $domains = [];
    static $FK = [];

    public $FormCalendarID;
    public $FormType;
    public $FormYear;
    public $FormSemester;
    public $FormCalendarPTitle;
    public $FormCalendarETitle;
    public $LogID;
    public $RecordStatus;
    
    public function getStatic($name){
        return self::$$name;
    }

    /** 
     * FormCalendar constructor.
     * @param array $headerInfo
     * @param null $id
     */
    public function __construct($headerInfo = array(), $id =null){

        $this->FormCalendarID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->FormType= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->FormYear= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->FormSemester= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->FormCalendarPTitle = DataMember::CreateDMA(DataMember::Pattern_FaAlphaNum);
        $this->FormCalendarETitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->LogID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        parent::__construct($headerInfo,$id);

    }
    
}//End of class FormCalendar