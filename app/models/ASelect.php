<?php

namespace Api\Models;

use Api\Models\BaseClass;
use DataMember;
use EntityClass;
use HeaderKey;
use InputValidation;

class ASelect extends BaseClass{

    /**
     * SuperGroup constructor.
     * @param array $headerInfo
     * @param null $id
     */
    public function __construct($headerInfo = array())
    {
        parent::__construct($headerInfo);

    }

    public function getLabel($id,$value){
        $res = self::getSelect($id,'',$value);
        return count($res) ? ["label"=>$res[0]['label']] : ["label"=>''];
    }

    public function getSelect($id,$search,$value=false){

        $mysql = parent::getDBConnection();

        switch($id){
            case 'LesID':
                $w = "concat(PLesName,' (',LesCode,'-',GrpCode,') سال تحصیلی ',Eduyear,'-',semester)";
                $search = "%$search%";
                if($value){
                    $w = "pl.LesID";
                    $search = $value;
                }
                $query = "SELECT pl.LesID as `value`,concat(PLesName,' (',LesCode,'-',GrpCode,') سال تحصیلی ',Eduyear,'-',semester) as `label` 
                        FROM PresentedLessons pl
                        inner join lessons l using(LesCode)
                        inner join PresentedLessonsProfs p on (p.LesID=pl.LesID)
                        inner join professors pf on (p.ProCode=pf.ProCode) 
                        where pl.LesStatus!=4 and pf.PersonID = :PersonID and EduYear in(1397,1398)
                            and $w like :label 
                            order by `label`";
                $mysql->Prepare($query);
                $PersonID = $this->headerInfo[HeaderKey::PERSON_ID]==487 ? 401368846 : $this->headerInfo[HeaderKey::PERSON_ID];
                $objArray = $mysql->ExecuteStatement(array(":PersonID"=>$PersonID,":label"=>$search));
                $objArray = $objArray->fetchAll();
                InputValidation::ArrayEncoding($objArray);
                return ($objArray);
            case 'StNo':
                if(!$value && ($search=='' || strlen($search)<4)) return array();
                $w = "concat(PLName,' ',PFName, ' ',StNo)";
                $search = "%$search%";
                if($value){
                    $w = "StNo";
                    $search = $value;
                }
                $query = "SELECT StNo as `value`,concat(PLName,' ',PFName, ' ',StNo) as `label` 
                        FROM StudentSpecs ss
                        inner join persons p using(PersonID) 
                        where 
                            $w like :label 
                            order by `label`";
                $mysql->Prepare($query);
                $objArray = $mysql->ExecuteStatement(array(":label"=>$search));
                $objArray = $objArray->fetchAll();
                InputValidation::ArrayEncoding($objArray);
                return ($objArray);
            case 'LesCode':
                if(!$value && ($search=='' || strlen($search)<4)) return array();
                $w = "concat(PLesName,' ',LesCode)";
                $search = "%$search%";
                if($value){
                    $w = "LesCode";
                    $search = $value;
                }
                $query = "SELECT LesCode as `value`,concat(PLesName,' ',LesTotalUnit,' واحد ',LesCode) as `label` 
                        FROM lessons 
                        where LesStatus='1' and
                            $w like :label 
                            order by `label`";
                $mysql->Prepare($query);
                $objArray = $mysql->ExecuteStatement(array(":label"=>$search));
                $objArray = $objArray->fetchAll();
                InputValidation::ArrayEncoding($objArray);
                return ($objArray);
            case 'FldCode':
                if(!$value && ($search=='' || strlen($search)<4)) return array();
                $w = "PFldName";
                $search = "%$search%";
                if($value){
                    $w = "FldCode";
                    $search = $value;
                }
                $query = "SELECT FldCode as `value`,PFldName as `label` 
                        FROM StudyFields 
                        where FieldStatus='ACTIVE' and FacCode!=82 and
                            $w like :label 
                            order by `label`";
                $mysql->Prepare($query);
                $objArray = $mysql->ExecuteStatement(array(":label"=>$search));
                $objArray = $objArray->fetchAll();
                InputValidation::ArrayEncoding($objArray);
                return ($objArray);
            case 'EduGrpCode':
                if(!$value && ($search=='' || strlen($search)<4)) return array();
                $w = "PEduName";
                $search = "%$search%";
                if($value){
                    $w = "EduGrpCode";
                    $search = $value;
                }
                $query = "SELECT EduGrpCode as `value`,PEduName as `label` 
                        FROM EducationalGroups 
                        where RecordStatus='ACTIVE' and FacCode!=82 and
                            $w like :label 
                            order by `label`";
                $mysql->Prepare($query);
                $objArray = $mysql->ExecuteStatement(array(":label"=>$search));
                $objArray = $objArray->fetchAll();
                InputValidation::ArrayEncoding($objArray);
                return ($objArray);
        }

    }

}

?>