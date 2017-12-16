<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 10/4/2017
 * Time: 5:57 AM
 */

namespace apps\acm\controller\admin\contest;


use apps\acm\controller\admin\BaseAdmin;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewContests extends BaseAdmin
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