<?php
/**
 * Author: rmahdizadeh
 * Date: 1398-04-30
 */
namespace Api\Controllers;

use Interop\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use pdodb;
use ResponseHelper;
use config;
use Api\Models\SuperGroup;


class SuperGroupsController extends BaseController{

  protected $container;
  protected $SuperGroup;

  public function __construct(ContainerInterface $container, SuperGroup $SuperGroup){
    /*$this->container = $container;
    $this->SuperGroup = $SuperGroup;*/
    parent::__construct($container,$SuperGroup);
  }

  public function testinsert(){
    return ResponseHelper::createSuccessfulResponse($response)
                    ->withHeader('Content-Type', 'application/json', JSON_UNESCAPED_UNICODE)
                    ->write(json_encode("hello"));
    /*$mysql = $this->obj->getDBConnection();
    $query = "SELECT count(*) as co FROM ".self::getTableName()." s where s.RecordStatus<>'DELETED'"
        .($wh!='' ? " and $wh " : "");
    $mysql->Prepare($query);
    $co = $mysql->ExecuteStatement($pa);

    $co = $co->fetch();
    return $co['co'];*/
  }
  /*public function selectAll(Request $request, Response $response, array $args){
    try{
      //$params= $request->getQueryParams();
      $objArray = $this->obj->GetAll();
      if($objArray) { 
        return ResponseHeloper::createSuccessfulResponse($response)
          ->withHeader('Cntent-Type', 'application/json', JSON_UNESCAPED_UNICODE)
            ->write(json_encode($objArray));
      }else{
        return ResponseHelper::createSuccessfulResponse($response, \HTTPStatusCodes::NO_CONTENT);
      }
    }catch (\Exception $ex) {
      return ResponseHelper::createfailureResponseByException($response,$ex->getMessage());
    }//End of try catch
  }//End of member function select*/

  /*public function select(Request $request, Response $response, array $args)
  {
      try{
          //$params= $request->getParsedBody();

          $this->obj->validateParams($args);
          $objArray = $this->obj->GetInfo($args['id']);//echo '<br>xxxxxx';print_r($objArray);echo '<br>'.json_encode($objArray).'<br>';
          if($objArray) {
              return ResponseHelper::createSuccessfulResponse($response)
                  ->withHeader('Content-Type', 'application/json', JSON_UNESCAPED_UNICODE)
                  ->write(json_encode($objArray));
          }
          else {
              return ResponseHelper::createfailureResponse($response, \HTTPStatusCodes::NO_CONTENT);
          }
      }catch (\Exception $ex) {
          return ResponseHelper::createfailureResponseByException($response,$ex->getMessage());//ErrorList::INVALID_QUERY_PARAMETER);
      }
  }*/
  
  /*public function delete(Request $request, Response $response, array $args)
    {echo '<br>delete<br>';
        echo $id = $args['id'];
        try{
            $this->obj->setId($id);
            $this->obj->doDelete();

            return ResponseHelper::createSuccessfulResponse($response, \HTTPStatusCodes::OK);

        }catch (\Exception $ex){
            return ResponseHelper::createfailureResponseByException($response,$ex->getMessage());
        }
    }*/

} //End of class SuperGroupsController