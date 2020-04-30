<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use HeaderKey;
use InputValidation;

class DocAttachment extends BaseClass{

    const TableName = "DocAttachments";
    const TableKey = "DocID";
    const ClassDesc = "مستندات";



    public $DocID;
    public $TargetTable ;
    public $TargetID ;
    public $path ;
    public $FileName ;
    public $FileType ;
    public $LogID;
    public $RecordStatus;
    
    /**
     * SuperGroup constructor.
     * @param array $headerInfo
     * @param null $id
     */
    public function __construct($headerInfo = array(), $id =null)
    {
        $this->DocID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->TargetTable  =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->TargetID  =  DataMember::CreateDMA(DataMember::Pattern_Num);
        //$this->path  =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->FileName  =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        //$this->FileType  =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

    public function getDoc($TargetTable,$TargetID){
        $mysql = self::getDBConnection();
        $query = "SELECT * FROM ".self::getTableName()." 
            where RecordStatus<>'DELETED' 
            and  TargetTable=:TargetTable and  TargetID = :TargetID
            order by ".self::getTablePk()." desc limit 1 ";
        $mysql->Prepare($query);
        $objArray = $mysql->ExecuteStatement(array(":TargetTable"=>$TargetTable,
                ":TargetID"=>$TargetID));
        $objArray = $objArray->fetch();
        //InputValidation::ArrayEncoding($objArray);
        return $objArray;
    }


}

?>