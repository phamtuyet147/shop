<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/18/2017
 * Time: 10:28 PM
 */

namespace apps\ctsv\controller;


use core\processor\AppFilter;
use core\processor\Filters;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

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
        $user = $request->getSession('user');
        if (strpos($request->getPagePath(), 'dang-nhap') !== false) {
            if (!empty($user)) {
                $response->redirect('/');
            }
            $filters->nextFilter();
            return;
        }
        if (empty($user)) {
            $response->redirect('/dang-nhap');
        }
        $filters->nextFilter();
    }
}