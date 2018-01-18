<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/18/2018
 * Time: 8:24 AM
 */

namespace apps\shop\controller\web\cart;


use apps\shop\controller\BaseAction;
use apps\shop\model\dao\ProductDAO;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewCart extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $cart = $request->getCookie('cart');
        if (!empty($cart)) {
            $cart = explode(',', $cart);
        } else {
            $cart = array();
        }

        $products = ProductDAO::getProductsInList($cart);
        $request->setAttribute('products', $products);
        $appView->doView('success');
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