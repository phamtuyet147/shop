<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/3/2017
 * Time: 8:37 PM
 */

namespace apps\ctsv\controller;


use apps\ctsv\object\User;
use core\app\AppFilter;
use core\processor\Filters;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class CheckAdminPermission implements AppFilter
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
        /** @var User $user */
        $user = $request->getSession('user');
        if (empty($user)) {
            $response->redirect('/dang-nhap');
        }
        if (!Configuration::isAdmin($user->getId())) {
            $response->redirect('/');
        }
        $filters->nextFilter();
    }
}