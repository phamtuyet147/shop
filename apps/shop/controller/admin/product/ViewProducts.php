<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/14/2018
 * Time: 11:58 PM
 */

namespace apps\shop\controller\admin\product;


use apps\shop\controller\BaseAction;
use apps\shop\model\dao\ProductDAO;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewProducts extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $products = ProductDAO::getProductsByConditions();

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