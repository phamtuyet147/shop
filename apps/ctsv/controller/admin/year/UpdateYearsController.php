<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/27/2017
 * Time: 6:17 AM
 */

namespace apps\ctsv\controller\admin\year;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\ReportUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class UpdateYearsController extends BaseAppController
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
        $years = $request->getParameter('years');
        if (empty($years)) {
            $response->redirect('/index.php?path=quan-ly/nam-bao-cao');
        }
        $update = ReportUtil::updateYears($years);
        $years = ReportUtil::getYears();
        $request->setSession('years', $years);
        if (!$update) {
            $request->setAttribute('reportYears', $years);
            $this->raiseError($request, 'Vui lòng nhập đầy đủ thông tin');
            $appView->doView('error');
        }
        $response->redirect('/index.php?path=quan-ly/nam-bao-cao');
    }
}