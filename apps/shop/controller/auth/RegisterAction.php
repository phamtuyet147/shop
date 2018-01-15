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

class RegisterAction extends BaseAction
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
        $name = $request->getParameter('name');
        $address = $request->getParameter('address');
        $email = $request->getParameter('email');
        $phone = $request->getParameter('phone');
        $password = $request->getParameter('password');

        $customer = CustomerDAO::getCustomerLoginInfoByPhoneOrEmail(
            $email, $phone
        );
        if ($customer) {
            $request->setAttribute(
                'wError',
                'Thông tin tài khoản đã tồn tại, vui lòng nhập thông tin khác, hoặc nếu đây là bạn, vui lòng Đăng nhập'
            );
            $appView->doView('success');
        }

        CustomerDAO::createCustomer($email, $phone, $password, $name, $address);
        $request->setAttribute(
            'wSuccess',
            'Đăng ký thành công'
        );
        $appView->doView('success');
    }
}