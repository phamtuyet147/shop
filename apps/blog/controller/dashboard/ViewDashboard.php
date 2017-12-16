<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 11/5/2017
 * Time: 4:50 PM
 */

namespace apps\blog\controller\dashboard;


use apps\blog\controller\BaseBlogController;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewDashboard extends BaseBlogController
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