<?php

namespace Api\Classes;

use Api\Models\CreditYear;
use Api\Models\UnitsCredit;
use PdoDataAccess;

class CreditsUtils
{
    protected $creditYear;
    protected $unitsCredit;

    /**
     * CreditsUtils constructor.
     * @param CreditYear $crYear
     * @param UnitsCredit $unitsCr
     */
    public function __construct(CreditYear $crYear,
                                UnitsCredit $unitsCr
                                )
    {
        $this->creditYear = $crYear;
        $this->unitsCredit = $unitsCr;


    }


    /**
     * @param array $educLevels
     * @param $numHours
     * @return float|int
     */
    public static function estimateBlockedCredit(array $educLevels, $numHours)
    {

        $educLevelsList = array(1=>'associate',2=>'bachelor',3=>'master', 4=>'PHD');
        $date = \DateModules::miladi_to_shamsi(date('Y-m-d', time()));
        $date = str_replace('/','-',$date);
        $maxEducLevel = max($educLevels);
        $res = PdoDataAccess::runquery("SELECT ".$educLevelsList[$maxEducLevel]." 
                                              FROM  studentwork.StudentWorkPrice 
                                              WHERE StartDate <= '".$date."' AND EndDate >= '".$date."'
                                              ORDER BY StudentWorkPriceID DESC");

        $blockedCredit = $res[0][0]*$numHours;
        return $blockedCredit;
    }

    /**
     * @param $date
     * @return mixed
     */
    public static function getCreditYear($date)
    {
        $res = PdoDataAccess::runquery("SELECT * FROM studentwork.CreditYear
                                                WHERE StartDate <= '".$date."'  AND EndDate >= '".$date."'
                                                ORDER BY CreditYearID");
        return $res[0];
    }

    /**
     * @return mixed
     */
    public static function getCurrentCreditYear()
    {
        $date = \DateModules::miladi_to_shamsi(date('Y-m-d', time()));
        $date = str_replace('/','-',$date);
        return self::getCreditYear($date);

    }

    /**
     * @param $ouid
     * @param int $creditYearID
     * @return mixed
     * @throws \Exception
     */
    public static function getUnitsCreditAmount($ouid, $creditYearID=0)
    {
        if($creditYearID === 0) {
            $creditYear= self::getCurrentCreditYear();
            $creditYearID = $creditYear['CreditYearID'];
        }
        $sql= "SELECT * FROM UnitsCredit where CreditYearID=:creditYear and ouid=:ouid";
        $res = PdoDataAccess::runquery($sql, array(':creditYear'=>$creditYearID, ':ouid'=>$ouid));

        return $res[0]['CreditAmount'];
    }

    /**
     * @param $ouid
     * @return mixed
     */
    public static function getUnitsEstimatedBlockedCredit($ouid)
    {
        $creditYear = self::getCurrentCreditYear();
        $res = PdoDataAccess::runquery("SELECT SUM(BlockedCredit) FROM studentwork.UnitsAppForStWork
                                             WHERE CreatedDate >='".$creditYear['StartDate']."' 
                                             AND  CreatedDate <='".$creditYear['EndDate']."' 
                                             AND ouid = '".$ouid."'");

        return $res[0][0];


    }

    /**
     * @param $ouid
     * @param int $creditYearID
     * @return int
     * @throws \Exception
     */
    public function getUnitsApprovedCredit($ouid, $creditYearID=0){

        if($creditYearID === 0) {
            $creditYear= self::getCurrentCreditYear();
            $creditYearID = $creditYear['CreditYearID'];
        }
        $objArr = $this->unitsCredit->doSelect(array('CreditYearID'=>$creditYearID, 'ouid'=>$ouid, 'CreditState'=>'APPROVED'),false);
        if(!empty($objArr[0]))
            return $objArr[0]->CreditAmount;
        else
            return 0;
    }

    public static function estimateBlockedCreditByWorkId($workId)
    {
        $sql= "select UA.UnitsAppForStWorkID, LQ.NumHours, EL.levels from UnitsAppForStWork  as UA
                left join UnitsAppEducLevelReq as LQ on UA.UnitsAppForStWorkID= LQ.UnitsAppForStWorkID
                left join ( select UnitsAppEducLevelReqID,GROUP_CONCAT(DISTINCT EducLevelsCode SEPARATOR ',') as levels from  UnitsAppEducLevelReq_EducLevels 
                            group by UnitsAppEducLevelReqID
                            )as EL
                            on EL.UnitsAppEducLevelReqID = LQ.UnitsAppEducLevelReqID
                where UA.UnitsAppForStWorkID = :id";
        $res = PdoDataAccess::runquery($sql, array(":id"=>$workId));

        if(!empty($res[0])){
            $lvls = explode(',',$res[0]['levels']);
            return self::estimateBlockedCredit($lvls, $res[0]['NumHours']);
        }
        else
            return 0;
    }


}