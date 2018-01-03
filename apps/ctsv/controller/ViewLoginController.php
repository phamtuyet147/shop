<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 9/17/2017
 * Time: 3:25 PM
 */

namespace apps\ctsv\controller;


use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewLoginController extends BaseAppController
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $appView->doView('success');
    }

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doPost(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        // TODO: Implement doPost() method.
    }
}