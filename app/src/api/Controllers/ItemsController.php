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
use Api\Models\Items;


class ItemsController{

    protected $container;
    protected $Items;

    public function __construct(ContainerInterface $container, Items $Items){
        $this->container = $container;
        $this->Items = $Items;
    }

    public function select(Request $request, Response $response, array $args){
        try{
            $params= $request->getParsedBody();
            echo $params['ItemID'];
            $objArray = $this->Items->GetAll($params['ItemID']);
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

} //End of class ItemsController