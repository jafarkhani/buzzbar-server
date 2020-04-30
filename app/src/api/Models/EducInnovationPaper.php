<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use InputValidation;

class EducInnovationPaper extends BaseClass{



    const TableName = "TPF_EducInnovationPapers";
    const TableKey = "RecID";
    const ClassDesc = "نوآوری آموزشی در قالب مقاله";
    static $SearchField = "";
    static $domains = ['TPF_EIP_PUB_TY'=>"PublisherType", 'TPF_EIP_PP'=>"PublicationPeriodCode"];
    static $FK = ["LanguageID"=>["type"=>"select"]];

    public $RecID;
    public $PersonID;
    public $title;
    public $PaperTitle;
    public $publisher;
    public $PublisherType;
    public $volume;
    public $PublicationPeriodCode;
    public $LanguageID;
    public $description;
    public $url;
    public $PublishDate;
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
        $this->PaperTitle =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->publisher =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->description =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->PublisherType =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->volume =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->PublicationPeriodCode =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->LanguageID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->url =  DataMember::CreateDMA(DataMember::Pattern_FaEnAlphaNum);
        $this->PublishDate  =  DataMember::CreateDMA(DataMember::Pattern_Date);
        $this->LogID =  DataMember::CreateDMA(DataMember::Pattern_Num);
        $this->RecordStatus =  DataMember::CreateDMA(DataMember::Pattern_EnAlphaNum);

        parent::__construct($headerInfo,$id);

    }

}

?>