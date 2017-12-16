<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 12/9/2017
 * Time: 6:09 PM
 */

namespace apps\blog\controller\admin\dashboard;


use apps\blog\controller\BaseBlogController;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewAdminDashboard extends BaseBlogController
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