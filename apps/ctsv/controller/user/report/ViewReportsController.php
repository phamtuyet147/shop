<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/22/2017
 * Time: 6:39 AM
 */

namespace apps\ctsv\controller\user\report;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\object\User;
use apps\ctsv\utils\ReportUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewReportsController extends BaseAppController
{

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param AppView      $appView
     *
     */
    public function execute(HTTPRequest $request,
        HTTPResponse $response,
        AppView $appView
    ) {
        /**
         * @var User $user
         */
        $user = $request->getSession('user');
        $yearId = $request->getSession('activeYear');
        $schoolId = $request->getSession('activeSchool');
        $reports = ReportUtil::getReports($yearId, $schoolId);
        $request->setAttribute('reports', $reports);
        $appView->doView('success');
    }
}