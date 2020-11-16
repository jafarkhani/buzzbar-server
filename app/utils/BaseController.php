<?php

namespace ProfPortfolio\Controllers;

use HeaderKey;
use Slim\Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use ResponseHelper;
use PdoDataAccess;
use Services;
use Api\models\DocAttachment as DocAttachment;

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
		$statement = $this->model->Get();
		print_r(\ExceptionHandler::PopAllExceptions());
		$count = $statement->rowCount();

		$start = (int) $params['start'];
		$limit = (int) $params['length'];
		$data = $start > 0
			? PdoDataAccess::fetchAll ($statement, $start, $limit)
			: $statement->fetchAll();

		$jsonData = array(
			"iTotalRecords" => $count,
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data
		);
		return ResponseHelper::createSuccessfulResponse($response)
			->withHeader('Content-Type', 'application/json', JSON_UNESCAPED_UNICODE)
			->write(json_encode($jsonData));
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

	public function insert(Request $request, Response $response, array $args) {
		try {

			$params = $request->getParsedBody();
			//$file = $request->getUploadedFiles();

			$this->model->validateParams($params);

			if (isset($params['PersonID'])) {
				if ($this->headerInfo[HeaderKey::PERSON_ID] != $params['PersonID'])
					throw new \Exception('دسترسی غیر مجاز');
			}

			$this->model->doInsert($params);
			$index = $this->model->{$this->model->getTablePk()};

			/* if($this->docObj && !empty($file['attachment'])) {
			  $fileType = $file['attachment']->getClientMediaType();

			  $fileName = $file['attachment']->getClientFilename();
			  $fileEx = substr($fileName,strrpos($fileName,'.')+1, strlen($fileName));

			  $pa = array(
			  "TargetTable" =>$this->model->getTableName(),
			  "TargetID" => $index,
			  "path" => $this->uploadDir,
			  "FileName" => $fileEx,
			  "FileType" => $fileType
			  );
			  $this->docObj->doInsert($pa);
			  $index = $this->docObj->{$this->docObj->getTablePk()};
			  $uploadDir = $this->uploadDir.$this->model->getTableName();
			  self::uploadFile($file['attachment'], $uploadDir, $index.'.'.$fileEx);
			  } */

			return ResponseHelper::createSuccessfulResponse($response, \HTTPStatusCodes::CREATED);
		} catch (\Exception $ex) {

			return ResponseHelper::createfailureResponseByException($response, $ex->getMessage());
		}
	}

	public function update(Request $request, Response $response, array $args) {
		try {
			$params = $request->getParsedBody();
			$file = $request->getUploadedFiles();

			//input validation
			$this->model->validateParams($params);

			if (isset($params['PersonID'])) {
				if ($this->headerInfo[HeaderKey::PERSON_ID] != $params['PersonID'])
					throw new \Exception('دسترسی غیر مجاز');
			}

			//setId() method does Input validation for id
			$this->model->setId($params['id']);
			$this->model->doUpdate($params);

			/* if($this->docObj && !empty($file['attachment'])) {

			  $fileType = $file['attachment']->getClientMediaType();

			  $fileName = $file['attachment']->getClientFilename();
			  $fileEx = substr($fileName,strrpos($fileName,'.')+1, strlen($fileName));

			  $pa = array(
			  "TargetTable" => $this->model->getTableName(),
			  "TargetID" => $params['id'],
			  "path" => $this->uploadDir,
			  "FileName" => $fileEx,
			  "FileType" => $fileType
			  );
			  $this->docObj->doInsert($pa);
			  $index = $this->docObj->{$this->docObj->getTablePk()};
			  $uploadDir = $this->uploadDir.$this->model->getTableName();
			  self::uploadFile($file['attachment'], $uploadDir, $index.'.'.$fileEx);
			  } */

			return ResponseHelper::createSuccessfulResponse($response, \HTTPStatusCodes::OK);
		} catch (\Exception $ex) {
			return ResponseHelper::createfailureResponseByException($response, $ex->getMessage());
		}
	}

	public function delete(Request $request, Response $response, array $args) {
		$id = $args['id'];
		try {
			$this->model->setId($id);
			$this->model->doDelete();

			return ResponseHelper::createSuccessfulResponse($response, \HTTPStatusCodes::OK);
		} catch (\Exception $ex) {
			return ResponseHelper::createfailureResponseByException($response, $ex->getMessage());
		}
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
