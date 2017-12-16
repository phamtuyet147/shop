<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/3/2017
 * Time: 7:04 PM
 */

namespace apps\ctsv\controller\admin\account;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\object\User;
use apps\ctsv\utils\UserUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class UpdateAccountController extends BaseAppController

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
        $userId = $request->getParameter('id_user');
        $username = $request->getParameter('username');
        $schools = $request->getParameter('schools');
        $password = $request->getParameter('password');
        if (empty($schools)
            || (empty($userId) && empty($username)
                && empty($password))
        ) {
            $this->raiseError($request, 'Vui lòng nhập đầy đủ thông tin');
            $user = new User();
            if (!empty($userId)) {
                $user = UserUtil::getUserById($userId);
                if (empty($user)) {
                    $request->setSession(
                        'errorMsg', 'Không tìm thấy thông tin tài khoản'
                    );
                    $response->redirect('/index.php?path=quan-ly/mau-bao-cao');
                }
            }
            $request->setAttribute('userId', $userId);
            $request->setAttribute('user', $user);
            $appView->doView('error');
        }
        if (empty($userId)) {
            UserUtil::createUser($username, $password, $schools);
        } else {
            UserUtil::updateSchools($userId, $schools);
            if (!empty($password)) {
                UserUtil::updateUserPassword($userId, $password);
            }
        }
        $response->redirect('/index.php?path=quan-ly/tai-khoan');
    }
}