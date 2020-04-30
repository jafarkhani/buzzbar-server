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
use Api\Models\InvitingProfessor as InvitingProfessor;
use PdoDataAccess;


class InvitingProfessorController extends BaseController
{

    public function __construct(ContainerInterface $container, InvitingProfessor $InvitingProfessor,DocAttachment $doc)
    {
        parent::__construct($container,$InvitingProfessor,$doc);
    }

}
