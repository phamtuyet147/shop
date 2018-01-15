<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/15/2018
 * Time: 11:12 AM
 */

namespace apps\shop\controller\auth;


use apps\shop\controller\BaseAction;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class LogoutAction extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $request->destroySession();
        $response->redirect('/');
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