<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/28/2017
 * Time: 5:43 AM
 */

namespace apps\ctsv\controller\admin\school;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\SchoolUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class UpdateSchoolsController extends BaseAppController
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
        $schools = $request->getParameter('schools');
        if (empty($schools)) {
            $response->redirect('/index.php?path=quan-ly/truong');
        }
        $update = SchoolUtil::updateSchools($schools);
        if (!$update) {
            $schools = SchoolUtil::getAllSchoolsInfo();
            $request->setAttribute('reportYears', $schools);
            $this->raiseError($request, 'Vui lòng nhập đầy đủ thông tin');
            $appView->doView('error');
        }
        $response->redirect('/index.php?path=quan-ly/truong');
    }
}