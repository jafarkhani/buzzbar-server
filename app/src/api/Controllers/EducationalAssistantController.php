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
use Api\Models\EducationalAssistant as EducationalAssistant;
use PdoDataAccess;


class EducationalAssistantController extends BaseController
{

    public function __construct(ContainerInterface $container, EducationalAssistant $EducationalAssistant,DocAttachment $doc)
    {
        parent::__construct($container,$EducationalAssistant,$doc);
    }

}
