<?php
/**
 * Author: M.Fattahi
 * Date: 1399-02
 */
namespace Api\Controllers;

use Interop\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use pdodb;
use ResponseHelper;
use config;
use Api\Models\FormCalendar;


class FormCalendarsController extends BaseController{

    protected $container;
    protected $FormCalendar;

    public function __construct(ContainerInterface $container, FormCalendar $FormCalendar){
        /*$this->container = $container;
        $this->FormCalendar = $FormCalendar;*/
        parent::__construct($container,$FormCalendar);
    }

} //End of class FormCalendarsController