<?php
/*
 * Author: M.Fattahi
 * Date: 1399-02
*/

namespace ProfPortfolio\Models;

use DataMember;

class IndicatorGroups extends \OperationClass {

    const TableName = "IndicatorGroups";
    const TableKey = "GroupID";

    public $GroupID;
    public $DeputyID;
    public $GroupPName;
    public $GroupEName;
    public $IsActive;
	
    public function __construct($id =null){

        $this->DT_GroupID = DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->DT_DeputyID = DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->DT_GroupPName = DataMember::CreateDMA(DataMember::Pattern_FaAlphaNum);
        $this->DT_GroupEName = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->DT_IsActive = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
		
        parent::__construct($id);
    }
    
}