<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/7/2018
 * Time: 1:28 PM
 */

namespace apps\shop\controller;


use core\app\AppController;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

abstract class BaseAction implements AppController
{

    /**
     * Controller constructor.
     *
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     */
    public function __construct(HTTPRequest $request, HTTPResponse $response)
    {
    }
}