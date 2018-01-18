<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/18/2018
 * Time: 5:42 AM
 */

namespace apps\shop\controller\admin\product;


use apps\shop\controller\BaseAction;
use apps\shop\model\dao\ProductDAO;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class SearchProduct extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $keyword = $request->getParameter('keyword');
        $products = ProductDAO::getProductsByConditions(
            array('keyword' => $keyword)
        );

        $request->setAttribute('keyword', $keyword);
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