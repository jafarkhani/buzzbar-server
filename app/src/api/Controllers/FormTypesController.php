<?php
/**
 * Author: rmahdizadeh
 * Date: 1398-05-05
 */
namespace Api\Controllers;

use Interop\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use pdodb;
use ResponseHelper;
use config;
use Api\Models\FormTypes;


class FormTypesController{

    protected $container;
    protected $FormTypes;

    public function __construct(ContainerInterface $container, FormTypes $FormTypes){
        $this->container = $container;
        $this->FormTypes = $FormTypes;
    }

    public function select(Request $request, Response $response, array $args){
        try{
            $params= $request->getParsedBody();
            echo $params['SuperFormTypeID'];
            $objArray = $this->FormTypes->GetAll($params['SuperFormTypeID']);
            if($objArray) {
                return ResponseHelper::createSuccessfulResponse($response)
                    ->withHeader('Content-Type', 'application/json', JSON_UNESCAPED_UNICODE)
                    ->write(json_encode($objArray));
            }else{
                return ResponseHelper::createSuccessfulResponse($response, \HTTPStatusCodes::NO_CONTENT);
            }
        }catch (\Exception $ex) {
            return ResponseHelper::createfailureResponseByException($response,$ex->getMessage());
        }//End of try catch
    }//End of member function select

} //End of class FormTypesController