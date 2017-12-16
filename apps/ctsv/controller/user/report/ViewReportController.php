<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/1/2017
 * Time: 5:49 AM
 */

namespace apps\ctsv\controller\user\report;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\ReportUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewReportController extends BaseAppController
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
        $pagePath = $request->getPagePath();
        $reportId = '';
        if (preg_match('/bao-cao\/([a-z0-9]+)/', $pagePath, $match)) {
            $reportId = $match[1];
        }
        if (empty($reportId)) {
            $response->redirect('/index.php?path=bao-cao');
        }
        $report = ReportUtil::getReportById($reportId);
        if (empty($report)) {
            $response->redirect('/index.php?path=bao-cao');
        }
        $request->setSession('report', $report);
        $request->setAttribute('report', $report);
        $appView->doView('success');
    }
}