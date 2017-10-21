<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace apps\blog\controller;


use core\app\AppFilter;
use core\processor\Filters;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

/**
 * Class CheckLoginFilter
 *
 * @package apps\blog\controller
 */
class CheckLoginFilter implements AppFilter
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param Filters      $filters
     *
     */
    public function doFilter(HTTPRequest $request, HTTPResponse $response,
        Filters $filters
    ) {
        $request->setSession('userId', 1);
        $userId = $request->getSession('userId');
        if (empty($userId)) {
            $response->redirect('/auth');
        }
        $filters->nextFilter();
    }
}