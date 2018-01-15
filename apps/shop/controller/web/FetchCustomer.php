<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/15/2018
 * Time: 11:00 AM
 */

namespace apps\shop\controller\web;


use apps\shop\controller\BaseAction;
use apps\shop\model\object\Customer;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class FetchCustomer extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        /**
         * @var Customer $customer
         */
        $customer = $request->getSession('customer');
        if (empty($customer)) {
            $html
                = '<li><a href="/login"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Đăng nhập</a></li>';
        } else {
            $html = '<li><a href="/profile">Xin chào, ' . $customer->getName()
                . '</a></li>' .
                '<li><a href="/logout">Thoát</a></li>';
        }

        $response->setContent($html);
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