<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/14/2018
 * Time: 9:25 PM
 */

namespace apps\shop\controller\web\category;


use apps\shop\controller\BaseAction;
use apps\shop\model\dao\CategoryDAO;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewCategory extends BaseAction
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
        $category = CategoryDAO::getCategoryByShortTag($shortTag);
        if (!$category) {
            $appView->doView('error');
        }
        $products = CategoryDAO::getProductsByCategoryId($category->getId());
        $request->setAttribute('category', $category);
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