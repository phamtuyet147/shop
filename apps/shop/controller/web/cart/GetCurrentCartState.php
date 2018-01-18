<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/18/2018
 * Time: 8:22 AM
 */

namespace apps\shop\controller\web\cart;


use apps\shop\controller\BaseAction;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class GetCurrentCartState extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $inCart = $request->getCookie('cart');
        if (empty($inCart)) {
            $inCart = 0;
        } else {
            $inCart = count(explode(',', $inCart));
        }
        $response->setContent($inCart);
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