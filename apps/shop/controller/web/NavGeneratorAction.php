<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/7/2018
 * Time: 7:38 PM
 */

namespace apps\shop\controller\web;


use apps\shop\controller\BaseAction;
use apps\shop\model\dao\CategoryDAO;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class NavGeneratorAction extends BaseAction
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $categories = CategoryDAO::getTopCategories();

        $html = '';
        foreach ($categories as $category) {
            $html .= '<div class="item-menu">' .
                '<a href="' . $category->getShortTag() . '">' .
                $category->getTitle() .
                '</a>' .
                '</div>';
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