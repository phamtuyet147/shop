<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/3/2018
 * Time: 5:46 PM
 */

namespace apps\ctsv\controller;


use core\app\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class NavGenerator extends BaseAppController
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     */
    public function doGet(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
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