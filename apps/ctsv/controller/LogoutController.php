<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/25/2017
 * Time: 6:13 AM
 */

namespace apps\ctsv\controller;


use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class LogoutController extends BaseAppController
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
        $request->destroySession();
        $this->message($request, 'Đăng xuất thành công');
        $appView->doView('success');
    }
}