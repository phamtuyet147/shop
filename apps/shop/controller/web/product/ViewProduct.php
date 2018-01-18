<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/18/2018
 * Time: 6:58 AM
 */

namespace apps\shop\controller\web\product;


use apps\shop\controller\BaseAction;
use apps\shop\model\dao\ProductDAO;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewProduct extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $shortTag = $request->getParameter('short_tag');
        $product = ProductDAO::getProductByShortTag($shortTag);
        if (!$product) {
            $appView->doView('error');
        }
        $thumbnail = $product->getThumbnail();
        $thumbnail = explode(',', $thumbnail);
        $product->setThumbnail($thumbnail);
        $request->setAttribute('product', $product);
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