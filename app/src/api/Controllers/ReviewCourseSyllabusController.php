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
use Api\Models\ReviewCourseSyllabus as ReviewCourseSyllabus;
use PdoDataAccess;


class ReviewCourseSyllabusController extends BaseController
{

    public function __construct(ContainerInterface $container, ReviewCourseSyllabus $ReviewCourseSyllabus,DocAttachment $doc)
    {
        parent::__construct($container,$ReviewCourseSyllabus,$doc);
    }

}
