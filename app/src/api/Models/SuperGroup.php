<?php
/**
 * Created by PhpStorm.
 * User: ehsani
 * Date: 12/31/18
 * Time: 1:07 PM
 */

namespace Api\Models;

use DataMember;
use Api\Models\BaseClass;
use EntityClass;
use InputValidation;

class SuperGroup extends BaseClass {

    const TableName = "SuperGroups";
    const TableKey = "RecID";
    const ClassDesc = "سرگروه آیتم های کارنمای جامع";
    static $domains = [];
    static $FK = [];

    const SuperGroupPTitle = "عنوان فارسی کارنمای جامع";
    const SuperGroupETitle = "عنوان لاتین کارنمای جامع";
    const SuperGroupOrder = "ترتیب نمایش";

    public $RecID;
    public $SuperGroupID;
    public $SuperGroupPTitle;
    public $SuperGroupETitle;
    public $SuperGroupOrder;
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
        $this->SuperGroupID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->SuperGroupID= DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->SuperGroupPTitle = DataMember::CreateDMA(DataMember::Pattern_FaAlphaNum);
        $this->SuperGroupETitle = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->SuperGroupOrder= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LogID= DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus = DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        parent::__construct($headerInfo,$id);

    }
    /*public function GetAll(){
      $mysql = parent::getReportDBConnection();
      $query = "SELECT * FROM SuperGroups where RecordStatus<>'DELETED' order by SuperGroupOrder";
      $mysql->Prepare($query);
      $objArray = $mysql->ExecuteStatement(array());
      $objArray = $objArray->fetchAll();
      InputValidation::ArrayEncoding($objArray);
      return $objArray;
    }*/

}