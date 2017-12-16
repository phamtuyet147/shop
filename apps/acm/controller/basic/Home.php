<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 9/23/2017
 * Time: 7:12 PM
 */

namespace apps\acm\controller\basic;


use apps\acm\controller\BaseAppController;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class Home extends BaseAppController
{

    /**
     * @param HTTPRequest $request
     * @param HTTPResponse $response
     * @param AppView $appView
     *
     */
    public function execute(HTTPRequest $request, HTTPResponse $response, AppView $appView)
    {
        $appView->doView('success');
    }
}