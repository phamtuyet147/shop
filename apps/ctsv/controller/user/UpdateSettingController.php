<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/2/2017
 * Time: 3:36 PM
 */

namespace apps\ctsv\controller\user;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\object\User;
use apps\ctsv\utils\UserUtil;
use core\processor\AppView;
use core\utils\HashUtil;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class UpdateSettingController extends BaseAppController
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
        $school = $request->getParameter('school');
        $year = $request->getParameter('year');
        $request->setSession('activeYear', $year);
        $request->setSession('activeSchool', $school);
        $newPassword = $request->getParameter('password_new');
        if (!empty($newPassword)) {
            $retypePassword = $request->getParameter('password_retype');
            if ($retypePassword != $newPassword) {
                $request->setSession('errorMsg', 'Mật khẩu không giống nhau');
                $response->redirect('/');
            }
            $oldPassword = $request->getParameter('password_old');
            $oldPassword = HashUtil::getHash($oldPassword);
            /** @var User $user */
            $user = $request->getSession('user');
            $userInfo = UserUtil::getUserInfo(
                $user->getUsername(), $oldPassword
            );
            if (empty($userInfo)) {
                $request->setSession(
                    'errorMsg',
                    'Mật khẩu cũ chưa chính xác, vui lòng kiểm tra lại'
                );
                $response->redirect('/');
            }
            UserUtil::updateUserPassword($user->getId(), $newPassword);
            $request->setSession('message', 'Cập nhật thành công');
            $response->redirect('/index.php?path=thoat');
        }
        $request->setSession('message', 'Cập nhật thành công');
        $response->redirect('/');
    }
}