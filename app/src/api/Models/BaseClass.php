<?php
/**
 * Created by PhpStorm.
 * User: rmahdizadeh
 * Date: 7/22/19
 * Time: 12:58 PM
 */
namespace Api\Models;
use EntityClass;
use HeaderKey;
use pdodb;
use config;
use InputValidation;
//use EducDB;

class BaseClass extends EntityClass{

    //protected  $headerInfo = array();

    function __construct($headerInfo = array(),$id = '')
    {
        $this->headerInfo = $headerInfo;
        parent::__construct($headerInfo,$id);
    }


  public static function getDBConnection(){
    return pdodb::getInstance(config::$db_servers['master']['host'],config::$db_servers['master']['profportfolio_user']
      ,config::$db_servers['master']['profportfolio_pass'],config::$db_servers['master']["profportfolio_db"]/*EducDB::DB_NAME*/);
  } // end of member function getDBConnection

  public static function getReportDBConnection(){
    if(config::$connect_status == config::NORMAL_CONNECTION)
      return pdodb::getInstance(config::$db_servers['slave']['host'],config::$db_servers['slave']['report_user']
        ,config::$db_servers['slave']['report_pass'],config::$db_servers['master']["profportfolio_db"]/*EducDB::DB_NAME*/);
    else
      return pdodb::getInstance(config::$db_servers['master']['host'],config::$db_servers['master']['profportfolio_user']
        ,config::$db_servers['master']['profportfolio_pass'],config::$db_servers['master']["profportfolio_db"]/*EducDB::DB_NAME*/);
  } // end of member function getDBConnection

    public function getDomains(){
        $mysql = self::getDBConnection();
        $domains = $this->getStatic('domains');
        $list = array();
        foreach ($domains as $domain=>$key){
            $list[] = "'$domain'";
        }
        $op =[];
        if(count($list)){

            $query = "SELECT * FROM domains where 
                    ActiveDomain='YES' and DomainName in (".implode(",",$list).") order by description ";
            $mysql->Prepare($query);
            $res = $mysql->ExecuteStatement(array());
            if($res->rowCount()){
                $op = array();
                while($rec=$res->fetch()){
                    if(isset($op[$domains[$rec['DomainName']]] ) )
                        $op[$domains[$rec['DomainName']]][$rec['DomainValue']] = $rec["description"];
                     else
                         $op[$domains[$rec['DomainName']]] = array($rec['DomainValue']=>$rec["description"]);
                }
            }
        }
        $select  =[] ;
        $FK = $this->getStatic('FK');
        foreach ($FK as $key=>$val)
            if(isset($val['type']) && $val['type']=='select'){
                $select[] = $key;
            }
        if(count($select)){
            foreach ($select as $sel){
                $op[$sel] = [];
                switch ($sel){
                    case 'semester':
                        $op[$sel] = ["1"=>"اول","2"=>'دوم',"3"=>'تابستان'];
                        break;
                    case 'EduSecCode' :
                        $query = "SELECT * FROM EducationalSections where EduSecCode in (2,3,5,6,7,13)";
                        $mysql->Prepare($query);
                        $res = $mysql->ExecuteStatement(array());
                        if($res->rowCount()) {
                            while($rec = $res->fetch())
                                $op[$sel][$rec['EduSecCode']] = $rec["PEduSecName"];
                        }
                        break;
                    case 'LanguageID' :
                        $query = "SELECT * FROM baseinfo.Languages";
                        $mysql->Prepare($query);
                        $res = $mysql->ExecuteStatement(array());
                        if($res->rowCount()) {
                            //$op[$sel] = array("0"=> "فارسی");
                            while($rec = $res->fetch())
                                $op[$sel]["{$rec['LanguageID']}"] = $rec["LanguageName"];
                            $op[$sel][0] =  "فارسی";
                        }
                        break;
                }
            }
        }
        return $op;
    }

    public function getInfoP($id){
        $mysql = self::getDBConnection();
        $query = "SELECT * FROM ".self::getTableName()." where RecordStatus<>'DELETED' 
            and ".self::getTablePk()."= :id  ";
        $mysql->Prepare($query);
        $objRes = $mysql->ExecuteStatement(array(":id"=>$id));
        $objArray = $objRes->fetch();

        $hasPermission = false;
        if($objRes->rowCount()) {
            if ($objArray['PersonID'] == $this->headerInfo[HeaderKey::PERSON_ID])
                $hasPermission = true;
            else {
                $query = "select * from framework.UserRoles ur
                inner join educ.professors p on (p.PersonID= :PersonID )
                where ur.UserID = :UserID and DeputyID=1 and RoleStatus!='DELETED'
                and (ur.Unitcode=p.FacultyCode or ur.UnitCode=255)
                and (ur.EduGrpCode=p.EduGrpCode or ur.EduGrpCode=65535)";
                $p = [":PersonID" => $objArray['PersonID'], ":UserID" => $this->headerInfo[HeaderKey::USER_ID]];

                //print_r( $objArray);
                //print_r($p);
                $mysql->Prepare($query);
                $res = $mysql->ExecuteStatement($p);
                if (!$res->rowCount())
                    return [];
                $hasPermission = true;
            }
        }
        if(!$hasPermission)
            return [];
        InputValidation::ArrayEncoding($objArray);
        return $objArray;

    }

  public function getInfo($id){
      $mysql = self::getDBConnection();
      $query = "SELECT * FROM ".self::getTableName()."  where RecordStatus<>'DELETED' 
            and ".self::getTablePk()."= :id ";
      $mysql->Prepare($query);
      $objArray = $mysql->ExecuteStatement(array(":id"=>$id));
      $objArray = $objArray->fetch();
      InputValidation::ArrayEncoding($objArray);
      return $objArray;

  }

    public function getAll($wh='',$pa=array(),$order='',$start='',$count=''){echo ' yes ';
        $mysql = self::getDBConnection();

        $domains = $this->getStatic('domains');
        $select = ', s.'.self::getTablePk().' as id ';
        if(count($domains)){
            foreach ($domains as $domain=>$col){
                $select .= ",get_domain_desc($col,'$domain') as {$col}_desc ";
            }
        }
        $extJoin = '';
        $FK = $this->getStatic('FK');
        if(count($FK)){echo ' fk ';
            foreach ($FK as $key=>$value){
                switch ($key){
                    case 'StNo':
                        $extJoin .= "  left join StudentSpecs ss on (s.StNo=ss.StNo)
                            left join persons p on (ss.PersonID=p.PersonID) ";
                        $select .= " ,concat(p.PFName,' ',p.PLName) as StNo_name ";
                        break;
                    case 'LesID':
                        $extJoin .= " left join PresentedLessons pl on (s.LesID=pl.LesID and pl.LesStatus!=42) 
                             left join lessons l on (pl.LesCode=l.LesCode) ";
                        $select .= " ,l.PLesName as LesID_PLesName,pl.GrpCode as LesID_GrpCode,pl.LesCode as LesID_LesCode
                            ,l.LesTotalUnit as  LesID_LesTotalUnit,pl.EduYear as LesID_EduYear,pl.semester as LesID_semester";
                        break;
                    case 'EduSecCode':
                        $extJoin .= "left join EducationalSections es on (s.EduSecCode=es.EduSecCode) ";
                        $select .= ",es.PEduSecName as EduSecCode_PEduSecName ";
                        break;
                    case 'semester':
                        $select .=",case when s.semester=1 then 'اول' when s.semester=2 then 'دوم' when s.semester=3 then 'تابستان' end as semester_desc ";
                        break;
                    case 'EduGrpCode':
                        $extJoin .= "left join EducationalGroups eg on (s.EduGrpCode=eg.EduGrpCode) ";
                        $select .= ",eg.PEduName as EduGrpCode_PEduName ";
                        break;
                    case 'LesCode':
                        $extJoin .= "left join lessons le on (s.LesCode=le.LesCode) ";
                        $select .= ",le.PLesName as LesCode_PLesName ";
                        break;
                    case 'LanguageID':
                        $extJoin .= "left join baseinfo.Languages lan on (s.LanguageID=lan.LanguageID) ";
                        $select .= ",lan.LanguageName as LanguageID_LanguageName ";
                        break;
                    case 'FldCode':
                        $extJoin .= "left join StudyFields ef on (s.FldCode=ef.FldCode) ";
                        $select .= ",ef.PFldName as FldCode_PFldName ";
                        break;

                }

            }
        }
        $query = "SELECT s.* $select FROM ".self::getTableName()." s 
            $extJoin
            where s.RecordStatus<>'DELETED'"
            .($wh!='' ? " and $wh " : "");
        //oreder show be validate
        if($order!=='')
            $query .= " order by $order ";
        if($start!=='' and $count!==''){
            $query .= " limit ".(int)$start." , ".(int)$count;
        }echo $query;
        $mysql->Prepare($query);
        $objArray = $mysql->ExecuteStatement($pa);

        $objArray = $objArray->fetchAll();
        InputValidation::ArrayEncoding($objArray);
        return $objArray;
    }


    public function getAllCount($wh='',$pa=array()){

        $mysql = self::getDBConnection();
        $query = "SELECT count(*) as co FROM ".self::getTableName()." s where s.RecordStatus<>'DELETED'"
            .($wh!='' ? " and $wh " : "");
        $mysql->Prepare($query);
        $co = $mysql->ExecuteStatement($pa);

        $co = $co->fetch();
        return $co['co'];
    }

    public static function validateParams(&$args)
    {
        $params = null;
        if ($args && !is_array($args)) {

            $tmp = explode('/', $args);
            if ($tmp) {
                $args = $tmp;
                foreach ($args as $key => $param) {
                    $temp = explode("=", $param);
                    $params[$temp[0]] = $temp[1];
                }
            } elseif($params===null) {
                $params = $args;
            }

        }else{
            $params = $args;
        }
        
        if ($params) {
            // remove empty elements
            array_filter($params,function($value) { return $value !== ''; });

            if(array_key_exists('id',$params)){
                $params[self::getTablePk()]=$params['id'];
                unset($params['id']);
            }
            
            $class= get_called_class();
            $obj= new $class();
            $properties = get_object_vars($obj);
            // Check for invalid query parameters
            if ($properties) {
                foreach ($properties as $property => $specification) {
                    if (array_key_exists($property, $params)) {
                        if (!InputValidation::validate($params[$property], $specification['DataType'])) {
                            //throw new \Exception("Input validation failed for ".$property."--".$specification['DataType']);
                            throw new \Exception("فرمت داده ورودی ".InputValidation::htmlEncode($params[$property]).'--'.$property."--".$specification['DataType'] ." صحیح نمی باشد ");
                        }
                    }
                }
            } else {
                throw new \Exception("No property for class");
            }
        }
        return true;
    }


    public function doDelete(){

        if (!$this->existId()) {
            //ExceptionHandler::ThrowException(self::ERR_Delete);
            throw new \Exception('This record is not in the table therefor can not be deleted.');
        }

        $this->RecordStatus = 'DELETED';
        $this->setId($this->id());

        $res = parent::update(self::getTableName(), $this, self::getTablePk() . " = :id", array(":id" => $this->id()));

        if($res === false){
            throw new \Exception('Failed to delete the record.');
        }

        /*$daObj = new DataAudit($this->headerInfo);
        $daObj->ActionType = DataAudit::Action_delete;
        $daObj->MainObjectID = $this->id();
        $daObj->TableName = self::getTableName();
        $daObj->execute();*/

        return $res;

    }

    public function setId($newValue){
        if (InputValidation::validate($newValue,InputValidation::Pattern_EnAlphaNum, false)){
           $this->{self::getTablePk()}= $newValue;
           return true;
        }
        else{
            throw new \Exception("Input validation failed for Id");
        }
    }

    public function existId(){

        if($this->id()!== null){
            $result = parent::runquery("SELECT * FROM ".self::getTableName()
                ." WHERE ".self::getTablePk()." = :id", array(":id" =>  $this->id()) );

            //To prevent XSS attack
            InputValidation::ArrayEncoding($result);

            if($result) {
                return true;
            }
        }
        return false;

    }

    public function doInsert($args= array()){
        $this->initializer($args);
        if(!$this->existId()){
            $obj = $this->prepareObjForSave($args);
            $properties = array_filter(get_object_vars($obj));

            // check if obj is not empty
            if(!empty($properties)) {
                // run before inserts
                $this->preInsert();
                $res = parent::insert(self::getTableName(), $obj);
                if ($res === false) {
                    //ExceptionHandler::ThrowException(self::ERR_Add);
                    //return false;
                    throw new \Exception('Failed to insert the record.');
                }
                $this->{$this->getTablePk()} = parent::InsertID();

                /*// run post inserts
                $this->postInsert();
                $daObj = new DataAudit($this->headerInfo);
                $daObj->ActionType = DataAudit::Action_add;
                $daObj->MainObjectID = $this->id();
                $daObj->TableName = self::getTableName();
                $daObj->execute();*/

                return $res;
            }else{
                throw new \Exception('Can not insert empty record in database');
            }

        } else{
            throw new \Exception('This record is already existed therefor can not be inserted');
        }

    }

    /**
     * @param array $args
     * @return bool
     * @throws \Exception
     */
    public function doUpdate($args = array())
    {
        if (!$this->existId()) {
            //ExceptionHandler::ThrowException(self::ERR_Edit);
            //return false;
            throw new \Exception('This record is not in the table therefor can not be updated.');
        }
        $obj = $this->prepareObjForSave($args);
        $obj->setId($this->id());
        $properties = array_filter(get_object_vars($obj));
        if (!empty($properties))
        {
            $res = parent::update(self::getTableName(), $obj, self::getTablePk() . " = :id", array(":id" => $this->id()));
            if ($res === false) {
                //ExceptionHandler::ThrowException(self::ERR_Edit);
                //return false;
                throw new \Exception('Failed to update the record.');
            }

            /*$daObj = new DataAudit($this->headerInfo);
            $daObj->ActionType = DataAudit::Action_update;
            $daObj->MainObjectID = $this->id();
            $daObj->TableName = self::getTableName();
            //var_dump($daObj);
            $daObj->execute();*/

            return $res;
        }
        else{
            throw new \Exception('Nothing to update the record.');
        }

    }

    private function initializer($values=array())
    {

        //////////////////////////
        if (!is_array($values)) {
            $values = array($values);
        }
        foreach ($values as $key=>$value){
            if(property_exists($this,$key)){
                $this->set($key,$value);
            }
        }


    }

}