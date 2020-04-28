<?php
/**
 * Created by PhpStorm.
 * User: ehsani
 * Date: 1/22/19
 * Time: 9:14 AM
 */
// Application middleware

use Slim\Http\Request;
use Slim\Http\Response;
use Api\ErrorList as ErrorList;

/**
 * This middleware checks for http request headers
 * @param Request $request
 * @param Response $response
 * @param callable $next
 * @return \Psr\Http\Message\ResponseInterface
 */
/*$app->add( function (Request $request, Response $response, callable $next) use($container) {
    //echo "test";
    //$headers = $request->getHeaders();
    $headers=$container->get('headerInfo');


    //print_r($headers);//
    if (isNullOrEmpty($headers[HeaderKey::API_KEY])) {
        return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::FORBIDDEN, ErrorList::API_KEY_IS_MISSING);
    }else {
        $apikey = $container->get('settings')['APIKey'];

        if ($headers[HeaderKey::API_KEY] !== $apikey) {
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::FORBIDDEN, ErrorList::INVALID_API_KEY);
        }
    }
        return $next($request, $response);
});*/
/*$app->add( function (Request $request, Response $response, callable $next) use($container) {
    //$headers = getHeaders($request);
    $headers=$container->get('headerInfo');


    if (isNullOrEmpty($headers[HeaderKey::PERSON_ID])) {
        if($headers[HeaderKey::PERSON_ID]=== ErrorList::INPUT_VALIDATION_FAILED)
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::INPUT_VALIDATION_FAILED_FOR_PERSON_ID);
        else
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::PERSON_ID_IS_MISSING);
    }
    if (isNullOrEmpty($headers[HeaderKey::USER_ID])) {
        if($headers[HeaderKey::USER_ID]=== ErrorList::INPUT_VALIDATION_FAILED)
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::INPUT_VALIDATION_FAILED_FOR_USER_ID);
        else
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::USER_ID_IS_MISSING);
    }
    if (isNullOrEmpty($headers[HeaderKey::USER_ROLES])) {
        if($headers[HeaderKey::USER_ROLES]=== ErrorList::INPUT_VALIDATION_FAILED)
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::INPUT_VALIDATION_FAILED_FOR_USER_ROLES);
        else
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::USER_ROLE_IS_MISSING);
    }
    if (isNullOrEmpty($headers[HeaderKey::SYS_KEY])) {
        if($headers[HeaderKey::SYS_KEY]=== ErrorList::INPUT_VALIDATION_FAILED)
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::INPUT_VALIDATION_FAILED_FOR_SYS_KEY);
        else
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::SYS_KEY_IS_MISSING);
    }
    if (isNullOrEmpty($headers[HeaderKey::IP_ADDRESS])) {
        if($headers[HeaderKey::IP_ADDRESS]=== ErrorList::INPUT_VALIDATION_FAILED)
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::INPUT_VALIDATION_FAILED_FOR_IP_ADDRESS);
        else
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::IP_ADDRESS_IS_MISSING);
    }


    if (isNullOrEmpty($headers[HeaderKey::H_TOKEN])) {
        return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::FORBIDDEN, ErrorList::H_TOKEN_IS_MISSING);
    }else{
        $salt = $container->get('settings')['hashSalt'].$headers[HeaderKey::PERSON_ID];
        $hash = password_hash($headers[HeaderKey::USER_ID], PASSWORD_BCRYPT, ["salt"=>$salt]);
        if($headers[HeaderKey::H_TOKEN] !== $hash){
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::FORBIDDEN, ErrorList::INVALID_TOKEN);
        }
    }

    return $next($request, $response);
});*/

/**
 * @param $obj
 * @return bool
 */
function isNullOrEmpty($obj) {

    if ($obj === null || $obj === "") {
        return true;
    }

    if (is_array($obj) && empty($obj)) {
        return true;
    }

    if($obj === ErrorList::INPUT_VALIDATION_FAILED){
        return true;
    }
    return false;
}

/**
 * @param $request
 * @return mixed
 */
function getHeaders($request) {
    $headers = $request->getHeaders();
    foreach ($headers as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', substr($name, 5))))] = $value;
        }
    }
    return $headers;
}



/**
 * This middleware checks for supported file formats
 * @param Request $request
 * @param Response $response
 * @param callable $next
 * @return \Psr\Http\Message\ResponseInterface
 */
$fileFilter = function(Request $request, Response $response, callable $next){

    $allowedFiles = ['image/jpeg', 'image/jpg', 'application/pdf'];
    $files = $request->getUploadedFiles();
    $flattened =Services::array_flatten($files);

    foreach ($flattened as $key=> $newFile){
        $newFileType = $newFile->getClientMediaType();

        if(!in_array($newFileType, $allowedFiles)) {
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::UNSUPPORTED_FILE_TYPE);
        }

    }
    return $next($request, $response);
};