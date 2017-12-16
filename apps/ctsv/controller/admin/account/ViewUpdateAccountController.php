<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/3/2017
 * Time: 7:06 PM
 */

namespace apps\ctsv\controller\admin\account;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\object\User;
use apps\ctsv\utils\SchoolUtil;
use apps\ctsv\utils\UserUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewUpdateAccountController extends BaseAppController
{

    /**
     * @param HTTPRequest $request
     * @param HTTPResponse $response
     * @param AppView $appView
     *
     */
    public function execute(HTTPRequest $request, HTTPResponse $response,
        AppView $appView
    ) {
        $user = new User();
        $pagePath = $request->getPagePath();
        $userId = '';
        if (preg_match('/tai-khoan\/([a-z0-9]+)/', $pagePath, $match)) {
            $userId = $match[1];
        }
        if (!empty($userId)) {
            $user = UserUtil::getUserById($userId);
            if (empty($user)) {
                $request->setSession(
                    'errorMsg', 'Không tìm thấy thông tin tài khoản'
                );
                $response->redirect('/index.php?path=quan-ly/tai-khoan');
            }
            $userSchools = SchoolUtil::getSchoolInfoByUserId($user->getId());
            $user->setSchools($userSchools);
        }
        $schools = SchoolUtil::getAllSchoolsInfo();
        if (empty($schools)) {
            $response->redirect('/index.php?path=quan-ly/truong');
        }
        $request->setAttribute('schools', $schools);
        $request->setAttribute('userInfo', $user);
        $request->setAttribute('userId', $userId);
        $appView->doView('success');
    }
}