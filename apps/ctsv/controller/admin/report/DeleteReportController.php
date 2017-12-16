<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/2/2017
 * Time: 4:44 PM
 */

namespace apps\ctsv\controller\admin\report;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\ReportUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class DeleteReportController extends BaseAppController
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
        if (preg_match('/DeleteReport\/([a-z0-9]+)/', $pagePath, $match)) {
            $reportId = $match[1];
        }
        if (empty($reportId)) {
            $response->redirect('/');
        }
        $delete = ReportUtil::deleteReport($reportId);
        if (!$delete) {
            $response->redirect('/');
        }
        $response->redirect('/index.php?path=quan-ly/bao-cao');
    }
}