<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 9/23/2017
 * Time: 7:12 PM
 */

namespace apps\acm\controller;


use core\app\AppController;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

abstract class BaseAppController implements AppController
{

    /**
     * AppController constructor.
     *
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     */
    public function __construct(HTTPRequest $request, HTTPResponse $response)
    {

    }
}