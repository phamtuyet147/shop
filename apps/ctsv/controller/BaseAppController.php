<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/19/2017
 * Time: 9:42 PM
 */

namespace apps\ctsv\controller;


use apps\ctsv\Configuration;
use apps\ctsv\object\User;
use apps\ctsv\utils\AppUtil;
use core\processor\AppController;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

abstract class BaseAppController implements AppController
{
    public function __construct(HTTPRequest $request, HTTPResponse $response)
    {
        AppUtil::init();
        $menu = Array(
            Array(
                'path' => '/',
                'icon' => '<i class="fa fa-home"></i>',
                'name' => 'Trang chủ'
            )
        );
        /** @var User $user */
        $user = $request->getSession('user');
        if (!empty($user)) {
            $menu[] = Array(
                'path' => '/index.php?path=bao-cao',
                'icon' => '<i class="fa fa-bar-chart"></i>',
                'name' => 'Báo cáo'
            );
            if (Configuration::isAdmin($user->getId())) {
                $menu[] = Array(
                    'path' => '/index.php?path=quan-ly',
                    'icon' => '<i class="fa fa-group"></i>',
                    'name' => 'Quản lý'
                );
            }
        }
        $activeYear = $request->getSession('activeYear');
        $activeSchool = $request->getSession('activeSchool');
        $years = $request->getSession('years');

        $error = $request->getSession('errorMsg');
        if (!empty($error)) {
            $request->removeSession('errorMsg');
            $this->raiseError($request, $error);
        }
        $message = $request->getSession('message');
        if (!empty($message)) {
            $request->removeSession('message');
            $this->message($request, $message);
        }

        $request->setAttribute('activeYear', $activeYear);
        $request->setAttribute('activeSchool', $activeSchool);
        $request->setAttribute('years', $years);
        $request->setAttribute('user', $user);
        $request->setAttribute('menu', $menu);
    }

    public function raiseError(HTTPRequest $request, $message)
    {
        $request->setAttribute('error', $message);
    }

    public function message(HTTPRequest $request, $message)
    {
        $request->setAttribute('message', $message);
    }
}