<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 10/3/2017
 * Time: 6:04 AM
 */

namespace apps\acm\controller\admin;


use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class Home extends BaseAdmin
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
        $appView->doView('success');
    }
}