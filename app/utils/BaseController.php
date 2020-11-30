<?php

namespace Utils;

use ReflectionClass;
use HeaderKey;
use Slim\Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use ResponseHelper;
use PdoDataAccess;
use ExceptionHandler;

class BaseController {

	protected $container;
	protected $logger;
	protected $model;
	protected $request;
	protected $response;
	protected $args;

	public function __construct(Container $container) {
		
		$this->container = $container;
		$this->logger = $this->container['logger'];
	}

	public function getDoc(Request $request, Response $response, array $args) {
		try {
			$params = $request->getParsedBody();

			$doc = $this->docObj->getDoc($this->model->getTableName(), (int) $params['id']);

			if (!$doc || !count($doc)) {
				return ResponseHelper::createfailureResponse($response, \HTTPStatusCodes::NO_CONTENT, "Not Found!!");
			} else {
				$file = $doc['path'] . $doc['TargetTable'] . "/" . $doc['DocID'] . "." . $doc['FileName'];
				if (file_exists($file)) {

					$mimetypes = array($doc['FileName'] => $doc['FileType']);
					$path_parts = pathinfo($file);
					if (array_key_exists($path_parts['extension'], $mimetypes)) {
						$mime = $mimetypes[$path_parts['extension']];
					} else {
						return $response->withJson('File type error', \HTTPStatusCodes::BAD_REQUEST);
					}

					$response = $response->withHeader('Content-Description', 'File Transfer')
							->withHeader('Content-Type', $mime . '#' . $doc['DocID'] . "." . $doc['FileName'])
							/* ->withHeader('Content-Disposition', 'attachment;filename="'.basename($file).'"') */
							->withAddedHeader("File-Name", basename($file))
							->withHeader('Expires', '0')
							->withHeader('Cache-Control', 'must-revalidate')
							->withHeader('Pragma', 'public')
							->withHeader('Content-Transfer-Encoding', 'binary')
							->withHeader('Content-Length', filesize($file));

					readfile($file);
					return $response;

					//return  Services::downloadFile($file, $response,array($doc['FileName'] => $doc['FileType'] ));
					/* $docC = readfile($file);
					  if(!$docC)
					  {
					  return ResponseHelper::createFailureResponse($response, \HTTPStatusCodes::NOT_FOUND);
					  }
					  $data = array("FileName"=>$doc['DocID'].".".$doc['FileName'],"FileType"=>$doc['FileType'],
					  "data"=>$docC);
					  print_r($data);
					  return ResponseHelper::createSuccessfulResponse($response)
					  ->withHeader('Content-Type', 'application/json', JSON_UNESCAPED_UNICODE)
					  ->write(json_encode($data)); */
				} else
					return ResponseHelper::createfailureResponse($response, \HTTPStatusCodes::NO_CONTENT);
			}
		} catch (\Exception $ex) {
			return ResponseHelper::createfailureResponseByException($response, $ex->getMessage()); //ErrorList::INVALID_QUERY_PARAMETER);
		}
	}

	public function selectAll(Request $request, Response $response, array $args) {

		$params = $request->getQueryParams();
		$this->model->validateParams($params);
		
		$where = "";
		$WhereParams = array();
		if(!empty($params["search"])){
			$this->model->createWhere($where, $WhereParams, $params["search"]);
		}			
		
		$statement = $this->model->Get($where, $WhereParams);
		$count = $statement->rowCount();

		$start = isset($params['offset']) ? (int)$params['offset'] : 0;
		$limit = isset($params['limit']) ? (int)$params['limit'] : 0;
		
		$data = PdoDataAccess::fetchAll ($statement, $start, $limit);
		
		return ResponseHelper::createBootstrapTable($response, $data, $statement->rowCount());
	}

	public function find(Request $request, Response $response, array $args) {

		$this->model->validateParams($args);
		$record = $this->model->FindRecord($args['id']); 
		if (!$record) {
			return ResponseHelper::createfailureResponse($response, \HTTPStatusCodes::NO_CONTENT);
		}

		return ResponseHelper::createSuccessfulResponse($response)
				->withHeader('Content-Type', 'application/json', JSON_UNESCAPED_UNICODE)
				->write(json_encode($record));
	}

	public function save(Request $request, Response $response, array $args) {
		
		$params = $request->getParsedBody();
		$file = $request->getUploadedFiles();

		PdoDataAccess::FillObjectByArray($this->model, $params);
		
		$reflectionClass = new ReflectionClass($this->model);
		$TableKey = $reflectionClass->getConstants()["TableKey"];
		if(empty($this->model->{ $TableKey }))
			$result = $this->model->Add();
		else
			$result = $this->model->Edit();

		if($result)
			return ResponseHelper::createSuccessfulResponse($response);
		else
			return ResponseHelper::createFailureResponseByException($response, 
					ExceptionHandler::GetExceptionsToString("<br>"));	
	}
	
	public function delete(Request $request, Response $response, array $args) {
		$id = $args['id'];
		
		$reflectionClass = new ReflectionClass($this->model);
		$TableKey = $reflectionClass->getConstants()["TableKey"];
		$class = get_class($this->model);
		$obj = new $class($id);
		
		if(empty($obj->{$TableKey}))
			return ResponseHelper::createFailureResponseByException ($response, "ID not found");
		
		$result = $obj->Remove();
		if(!$result)
			return ResponseHelper::createFailureResponseByException ($response, ExceptionHandler::GetExceptionsToString());

		return ResponseHelper::createSuccessfulResponse($response, \HTTPStatusCodes::OK);
		
	}

	public static function uploadFile($file, $uploadDir, $fileName) {
		if (!empty($file)) {

			$attachment = $file;
			echo $attachment->getError();
			if ($attachment->getError() === UPLOAD_ERR_OK) {
				echo "no error";
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
			} else {

				throw new \Exception('خطا در باگذاری فایل');
			}
		}
	}

}
