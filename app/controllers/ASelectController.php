<?php
/**
 * Created by PhpStorm.
 * User: ehsani
 * Date: 1/7/19
 * Time: 11:40 AM
 */

namespace Api\Controllers;
use Api\Models\DocAttachment;
use Interop\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use ResponseHelper;
use Api\Models\ASelect as ASelect;
use PdoDataAccess;


class ASelectController extends BaseController
{

    public function __construct(ContainerInterface $container, ASelect $ASelect)
    {
        parent::__construct($container,$ASelect);
    }

    public function select(Request $request, Response $response, array $args)
    {
        try{
            $params= $request->getParsedBody();
            $objArray = $this->obj->getSelect($params['id'],$params['search']);

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


    public function label(Request $request, Response $response, array $args)
    {
        try{
            $params= $request->getParsedBody();

            $objArray = $this->obj->getLabel($params['id'],$params['value']);

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

}
