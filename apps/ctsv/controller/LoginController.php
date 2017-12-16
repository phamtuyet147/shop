<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/18/2017
 * Time: 10:38 PM
 */

namespace apps\ctsv\controller;


use apps\ctsv\Configuration;
use apps\ctsv\utils\ReportUtil;
use apps\ctsv\utils\SchoolUtil;
use apps\ctsv\utils\UserUtil;
use core\processor\AppView;
use core\utils\HashUtil;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class LoginController extends BaseAppController
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
        $username = $request->getParameter('username');
        $password = $request->getParameter('password');
        $password = HashUtil::getHash($password);
        $userInfo = UserUtil::getUserInfo($username, $password);
        if (empty($userInfo)) {
            $this->raiseError(
                $request,
                'Thông tin đăng nhập không hợp lệ, vui lòng kiểm tra lại'
            );
            $appView->doView('error');
        }
        if (Configuration::isAdmin($userInfo->getId())) {
            $schools = SchoolUtil::getAllSchoolsInfo();
        } else {
            $schools = SchoolUtil::getSchoolInfoByUserId(
                $userInfo->getId()
            );
        }
        $years = ReportUtil::getYears();
        $activeYear = '';
        $activeSchool = '';
        if (!empty($years)) {
            $activeYear = $years[0]->getId();
        }
        if (!empty($schools)) {
            $activeSchool = $schools[0]->getId();
        }
        $userInfo->setSchools($schools);
        $request->setSession('user', $userInfo);
        $request->setSession('years', $years);
        $request->setSession('activeYear', $activeYear);
        $request->setSession('activeSchool', $activeSchool);
        $response->redirect('/');
    }
}