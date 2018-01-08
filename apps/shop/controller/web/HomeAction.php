<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/7/2018
 * Time: 1:27 PM
 */

namespace apps\shop\controller\web;


use apps\shop\controller\BaseAction;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class HomeAction extends BaseAction
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