<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/15/2018
 * Time: 12:20 AM
 */

namespace apps\shop\controller\auth;


use apps\shop\controller\BaseAction;
use apps\shop\model\dao\CustomerDAO;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class LoginAction extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        if (!$request->isPost()) {
            $appView->doView('success');
        }
    }

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doPost(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $loginName = $request->getParameter('username');
        $password = $request->getParameter('password');

        $customer = CustomerDAO::authenticateCustomer($loginName, $password);
        if (!$customer) {
            $request->setAttribute(
                'wError', 'Thông tin đăng nhập không hợp lệ'
            );
            $appView->doView('success');
        }

        $customer = CustomerDAO::getCustomerInfo(
            $customer->getId(), $customer->getPhone(), $customer->getEmail()
        );
        $request->setSession('customer', $customer);
        $lastRoute = $request->getSession('lastRoute');
        if (!empty($lastRoute)) {
            $response->redirect($lastRoute);
        }
        $response->redirect('/');
    }
}