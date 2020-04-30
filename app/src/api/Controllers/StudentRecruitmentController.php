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
use Api\Models\StudentRecruitment as StudentRecruitment;
use PdoDataAccess;


class StudentRecruitmentController extends BaseController
{

    public function __construct(ContainerInterface $container, StudentRecruitment $StudentRecruitment,DocAttachment $doc)
    {
        parent::__construct($container,$StudentRecruitment,$doc);
    }

}
