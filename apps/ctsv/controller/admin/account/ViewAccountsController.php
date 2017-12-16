<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/26/2017
 * Time: 9:34 PM
 */

namespace apps\ctsv\controller\admin\account;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\UserUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewAccountsController extends BaseAppController
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
        $users = UserUtil::getUsers();
        $request->setAttribute('users', $users);
        $appView->doView('success');
    }
}