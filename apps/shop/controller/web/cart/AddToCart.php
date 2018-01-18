<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/18/2018
 * Time: 7:51 AM
 */

namespace apps\shop\controller\web\cart;


use apps\shop\controller\BaseAction;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class AddToCart extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        // TODO: Implement doGet() method.
    }

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doPost(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $result = array(
            'code'    => 0,
            'message' => ''
        );

        $id = $request->getParameter('id');
        if (empty($id)) {
            $result = array(
                'code'    => 1,
                'message' => 'Thiếu mã sản phẩm'
            );
            $response->setContent(json_encode($result));
            return;
        }

        $cart = $request->getCookie('cart');
        if (!empty($cart)) {
            $cart = explode(',', $cart);
        } else {
            $cart = array();
        }
        if (!in_array($id, $cart)) {
            $cart[] = $id;
            $request->setCookie('cart', implode(',', $cart), 86400);
        }
        $result['data'] = count($cart);
        $response->setContent(json_encode($result));
    }
}