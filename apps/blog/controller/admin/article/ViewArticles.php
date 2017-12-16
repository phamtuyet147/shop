<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 12/9/2017
 * Time: 10:08 PM
 */

namespace apps\blog\controller\admin\article;


use apps\blog\controller\BaseBlogController;
use apps\blog\model\dao\ArticleDAO;
use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewArticles extends BaseBlogController
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     *
     */
    public function execute(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $articles = ArticleDAO::getArticles();

        $request->setAttribute('articles', $articles);

        $appView->doView('success');
    }
}