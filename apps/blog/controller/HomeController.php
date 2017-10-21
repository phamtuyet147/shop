<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace apps\blog\controller;


use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class HomeController extends BaseBlogController
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function execute(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $appView->doView('success');
    }
}