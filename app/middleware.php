<?php


use Slim\Http\Request;
use Slim\Http\Response;

$app->add( function (Request $request, Response $response, callable $next) use($container) {
    
	$result = HeaderControl::AuthenticateHeaders($container["headerInfo"], $container);
	if($result !== true){
		return ResponseHelper::createfailureResponse($response, $result, ExceptionHandler::PopException()["Desc"]);
	}
    return $next($request, $response);
});


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

    foreach ($flattened as $key => $newFile){
        $newFileType = $newFile->getClientMediaType();

        if(!in_array($newFileType, $allowedFiles)) {
            return ResponseHelper::createfailureResponse($response, HTTPStatusCodes::BAD_REQUEST, ErrorList::UNSUPPORTED_FILE_TYPE);
        }

    }
    return $next($request, $response);
};