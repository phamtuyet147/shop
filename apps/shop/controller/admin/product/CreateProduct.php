<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/14/2018
 * Time: 11:59 PM
 */

namespace apps\shop\controller\admin\product;


use apps\shop\controller\BaseAction;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class CreateProduct extends BaseAction
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
        $title = $request->getParameter('title');
        $price = $request->getParameter('price');
        $shortDesc = $request->getParameter('short_desc');
        $desc = $request->getParameter('desc');
        $pictures = $request->getFileParam('pictures');


    }
}