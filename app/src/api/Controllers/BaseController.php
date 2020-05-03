<?php
/**
 * Created by PhpStorm.
 * User: ehsani
 * Date: 1/7/19
 * Time: 11:40 AM
 */

namespace Api\Controllers;

use HeaderKey;
use Interop\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use ResponseHelper;
use PdoDataAccess;
use Services;
use Api\Models\DocAttachment as DocAttachment;



class BaseController
{
    protected $logger;
    protected $pdo;
    protected $obj;
    protected $docObj;
    //protected $uploadDir;
    protected $headerInfo;

    public function __construct(ContainerInterface $container, $obj,$doc= false)
    {
        $this->logger = $container->get('logger');
        $this->pdo = $container->get('pdo');
        //$this->uploadDir = $container->get('upload_directory');
        $this->obj = $obj;
        //$this->docObj = $doc;
        $this->headerInfo = $container->get('headerInfo');
    }

    public function getDoc(Request $request, Response $response, array $args){
        try {
            $params = $request->getParsedBody();

            $doc = $this->docObj->getDoc($this->obj->getTableName(), (int)$params['id']);

            if(!$doc || !count($doc)){
                return ResponseHelper::createfailureResponse($response, \HTTPStatusCodes::NO_CONTENT,"Not Found!!");
            }else{
                $file = $doc['path'].$doc['TargetTable']."/".$doc['DocID'].".".$doc['FileName'];
                if(file_exists($file)){

                        $mimetypes = array($doc['FileName'] => $doc['FileType'] );
                        $path_parts = pathinfo($file);
                        if (array_key_exists($path_parts['extension'], $mimetypes)) {
                            $mime = $mimetypes[$path_parts['extension']];
                        } else {
                            return $response->withJson('File type error',\HTTPStatusCodes::BAD_REQUEST);
                        }

                        $response = $response->withHeader('Content-Description', 'File Transfer')
                            ->withHeader('Content-Type', $mime.'#'.$doc['DocID'].".".$doc['FileName'])
                            /*->withHeader('Content-Disposition', 'attachment;filename="'.basename($file).'"')*/
                            ->withAddedHeader("File-Name",basename($file))
                            ->withHeader('Expires', '0')
                            ->withHeader('Cache-Control', 'must-revalidate')
                            ->withHeader('Pragma', 'public')
                            ->withHeader('Content-Transfer-Encoding','binary')
                            ->withHeader('Content-Length', filesize($file));

                        readfile($file);
                    return $response;

                    //return  Services::downloadFile($file, $response,array($doc['FileName'] => $doc['FileType'] ));
                    /*$docC = readfile($file);
                    if(!$docC)
                    {
                        return ResponseHelper::createFailureResponse($response, \HTTPStatusCodes::NOT_FOUND);
                    }
                    $data = array("FileName"=>$doc['DocID'].".".$doc['FileName'],"FileType"=>$doc['FileType'],
                        "data"=>$docC);
                    print_r($data);
                    return ResponseHelper::createSuccessfulResponse($response)
                        ->withHeader('Content-Type', 'application/json', JSON_UNESCAPED_UNICODE)
                        ->write(json_encode($data));*/
                }
                else
                    return ResponseHelper::createfailureResponse($response, \HTTPStatusCodes::NO_CONTENT);
            }
        }catch (\Exception $ex) {
            return ResponseHelper::createfailureResponseByException($response,$ex->getMessage());//ErrorList::INVALID_QUERY_PARAMETER);
        }
    }

    public function selectDomains(Request $request, Response $response, array $args){
        try {
            $data = $this->obj->getDomains();
            return ResponseHelper::createSuccessfulResponse($response)
                ->withHeader('Content-Type', 'application/json', JSON_UNESCAPED_UNICODE)
                ->write(json_encode($data));
        }catch (\Exception $ex) {
            return ResponseHelper::createfailureResponseByException($response,$ex->getMessage());//ErrorList::INVALID_QUERY_PARAMETER);
        }

    }

    public function selectAll(Request $request, Response $response, array $args)
    {
        try{

            $params= $request->getParsedBody();

            $this->obj->validateParams($params);


            /*$PersonID = $this->headerInfo[HeaderKey::PERSON_ID];
            $co = $this->obj->getAllCount("PersonID = :PersonID" ,array(":PersonID"=>$PersonID));

            if($co>0){
                $wcl = "s.PersonID = :PersonID";
                $wp = array(":PersonID"=>$PersonID);
                //inputevalidation for $params["searchValue"]

                if($params["searchValue"]!=''){
                   $wcl .= " and s.".$this->obj->getStatic("SearchField")." like  :sf ";
                   $wp[":sf"] = "%".$params["searchValue"]."%";
                   $fco = $this->obj->getAllCount($wcl ,$wp);
                }
                else{
                    $fco = $co;
                }

                $order = $params['order']." ".$params['orderDir'];

                $data = $this->obj->getAll($wcl,$wp,$order,(int)$params['start'],(int)$params['rowperpage']);

                $data = array(
                    "iTotalRecords" => $fco,
                    "iTotalDisplayRecords" => $co,
                    "aaData" => $data
                );

            }
            else{
                $data = array(
                    "iTotalRecords" => 0,
                    "iTotalDisplayRecords" => 0,
                    "aaData" => array() //array of data fetched from db
                );
            }*/
            $data = $this->obj->GetAll();
            if($data) {
                return ResponseHelper::createSuccessfulResponse($response)
                    ->withHeader('Content-Type', 'application/json', JSON_UNESCAPED_UNICODE)
                    ->write(json_encode($data));
            }
            else {
                return ResponseHelper::createfailureResponse($response, \HTTPStatusCodes::NO_CONTENT);
            }
        }catch (\Exception $ex) {
            return ResponseHelper::createfailureResponseByException($response,$ex->getMessage());//ErrorList::INVALID_QUERY_PARAMETER);
        }
    }

    /*public function select(Request $request, Response $response, array $args)
    {
        try{
            $params= $request->getParsedBody();

            $this->obj->validateParams($params);
            $objArray = $this->obj->GetInfoP($params['id']);
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
         public function select(Request $request, Response $response, array $args)
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
      }

    public function insert(Request $request, Response $response, array $args)
    {
        try{

            $params= $request->getParsedBody();
            //$file = $request->getUploadedFiles();
            
            $this->obj->validateParams($params);

            if(isset($params['PersonID'])){
                if($this->headerInfo[HeaderKey::PERSON_ID]!=$params['PersonID'])
                    throw new \Exception('دسترسی غیر مجاز');
            }

            $this->obj->doInsert($params);
            $index = $this->obj->{$this->obj->getTablePk()};

            /*if($this->docObj && !empty($file['attachment'])) {
                $fileType = $file['attachment']->getClientMediaType();

                $fileName = $file['attachment']->getClientFilename();
                $fileEx = substr($fileName,strrpos($fileName,'.')+1, strlen($fileName));

                $pa = array(
                    "TargetTable" =>$this->obj->getTableName(),
                    "TargetID" => $index,
                    "path" => $this->uploadDir,
                    "FileName" => $fileEx,
                    "FileType" => $fileType
                );
                $this->docObj->doInsert($pa);
                $index = $this->docObj->{$this->docObj->getTablePk()};
                $uploadDir = $this->uploadDir.$this->obj->getTableName();
                self::uploadFile($file['attachment'], $uploadDir, $index.'.'.$fileEx);
            }*/

            return ResponseHelper::createSuccessfulResponse($response, \HTTPStatusCodes::CREATED);

        }catch (\Exception $ex) {

            return ResponseHelper::createfailureResponseByException($response,$ex->getMessage() );
        }
    }


    public function update(Request $request, Response $response, array $args)
    {echo 'ttttt';
        try{echo '<br>args : ';print_r($args);
            $params= $request->getParsedBody();echo '<br>paramsss : ';print_r($params);
            //$file = $request->getUploadedFiles();

            //input validation
            $this->obj->validateParams($params);

            /*if(isset($params['PersonID'])){
                if($this->headerInfo[HeaderKey::PERSON_ID]!=$params['PersonID'])
                    throw new \Exception('دسترسی غیر مجاز');
            }*/
            
            //setId() method does Input validation for id
            $this->obj->setId($args['id']);
            $this->obj->doUpdate($params);

            /*if($this->docObj && !empty($file['attachment'])) {

                $fileType = $file['attachment']->getClientMediaType();

                $fileName = $file['attachment']->getClientFilename();
                $fileEx = substr($fileName,strrpos($fileName,'.')+1, strlen($fileName));

                $pa = array(
                    "TargetTable" => $this->obj->getTableName(),
                    "TargetID" => $params['id'],
                    "path" => $this->uploadDir,
                    "FileName" => $fileEx,
                    "FileType" => $fileType
                );
                $this->docObj->doInsert($pa);
                $index = $this->docObj->{$this->docObj->getTablePk()};
                $uploadDir = $this->uploadDir.$this->obj->getTableName();
                self::uploadFile($file['attachment'], $uploadDir, $index.'.'.$fileEx);
            }*/

            return ResponseHelper::createSuccessfulResponse($response, \HTTPStatusCodes::OK);
        }
        catch (\Exception $ex) {
            return ResponseHelper::createfailureResponseByException($response,$ex->getMessage());
        }
    }


    public function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        try{
            $this->obj->setId($id);
            $this->obj->doDelete();

            return ResponseHelper::createSuccessfulResponse($response, \HTTPStatusCodes::OK);

        }catch (\Exception $ex){
            return ResponseHelper::createfailureResponseByException($response,$ex->getMessage());
        }
    }


    public static function uploadFile($file, $uploadDir, $fileName){
        if (!empty($file)) {

            $attachment = $file;
            echo $attachment->getError();
            if ($attachment->getError() === UPLOAD_ERR_OK) { echo "no error";
                if (!is_dir("$uploadDir")) {
                    mkdir("$uploadDir", 0777, true);
                }

                //$fileType = $attachment->getClientMediaType();
                //$fileType = substr($fileType,strpos($fileType,'/')+1, strlen($fileType));

                //substr($fileName,0, strpos($fileName,'.'));
                //$fileName = "$fileName.$fileType";

                $filePath = "$uploadDir/$fileName";
                $attachment->moveTo($filePath);
                return $fileName;
            }else{

                throw new \Exception('خطا در باگذاری فایل');           }

        }
    }


}
