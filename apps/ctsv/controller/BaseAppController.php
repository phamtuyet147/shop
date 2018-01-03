<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/19/2017
 * Time: 9:42 PM
 */

namespace apps\ctsv\controller;


use apps\ctsv\object\User;
use apps\ctsv\utils\AppUtil;
use core\app\AppController;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

abstract class BaseAppController implements AppController
{
    public function __construct(HTTPRequest $request, HTTPResponse $response)
    {
        AppUtil::init();
    }

    public function raiseError(HTTPRequest $request, $message)
    {
        $request->setAttribute('error', $message);
    }

    public function message(HTTPRequest $request, $message)
    {
        $request->setAttribute('message', $message);
    }
}