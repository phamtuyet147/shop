<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/17/2017
 * Time: 10:02 PM
 */

namespace apps\ctsv\controller;


use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class HomeController extends BaseAppController
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     *
     */
    public function execute(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $request->setAttribute('variable', 'variables');
        $appView->doView('success');
    }
}