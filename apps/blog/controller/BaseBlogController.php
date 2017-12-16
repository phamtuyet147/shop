<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 11/5/2017
 * Time: 4:48 PM
 */

namespace apps\blog\controller;


use core\app\AppController;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

abstract class BaseBlogController implements AppController
{

    /**
     * Controller constructor.
     *
     * @param HTTPRequest $request
     * @param HTTPResponse $response
     */
    public function __construct(HTTPRequest $request, HTTPResponse $response)
    {

    }
}