<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/2/2017
 * Time: 9:17 PM
 */

namespace apps\ctsv\controller\admin\report;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\ReportUtil;
use apps\ctsv\utils\SchoolUtil;
use apps\ctsv\utils\TemplateUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewUpdateReportController extends BaseAppController
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
            $response->redirect('/index.php?path=quan-ly/bao-cao');
        }
        $report = ReportUtil::getReportById($reportId);
        if (empty($report)) {
            $response->redirect('/index.php?path=quan-ly/bao-cao');
        }
        $templates = TemplateUtil::getTemplates();
        if (empty($templates)) {
            $response->redirect('/index.php?path=quan-ly/tao-mau-bao-cao');
        }
        $years = $request->getSession('years');
        if (empty($years)) {
            $response->redirect('/index.php?path=quan-ly/nam-bao-cao');
        }
        $schools = SchoolUtil::getAllSchoolsInfo();
        if (empty($schools)) {
            $response->redirect('/index.php?path=quan-ly/truong');
        }
        $request->setAttribute('templates', $templates);
        $request->setAttribute('years', $years);
        $request->setAttribute('schools', $schools);
        $request->setAttribute('report', $report);
        $appView->doView('success');
    }
}