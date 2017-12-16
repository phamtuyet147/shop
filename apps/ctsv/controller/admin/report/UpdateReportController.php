<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/2/2017
 * Time: 10:04 PM
 */

namespace apps\ctsv\controller\admin\report;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\ReportUtil;
use apps\ctsv\utils\SchoolUtil;
use apps\ctsv\utils\TemplateUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class UpdateReportController extends BaseAppController
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
        $reportId = $request->getParameter('id_report');
        $name = $request->getParameter('name');
        $yearId = $request->getParameter('id_year');
        $expireDate = $request->getParameter('dt_expire');
        $templateId = $request->getParameter('id_template');
        if (empty($name) || empty($yearId) || empty($expireDate)
            || empty($templateId)
        ) {
            $report = ReportUtil::getReportById($reportId);
            $templates = TemplateUtil::getTemplates();
            $years = $request->getSession('years');
            $schools = SchoolUtil::getAllSchoolsInfo();
            $request->setAttribute('templates', $templates);
            $request->setAttribute('years', $years);
            $request->setAttribute('schools', $schools);
            $request->setAttribute('report', $report);
            $request->setAttribute('reportId', $reportId);
            $this->raiseError($request, 'Vui lòng nhập đầy đủ thông tin');
            $appView->doView('error');
        }
        ReportUtil::updateReport(
            $reportId, $name, $templateId, $yearId, $expireDate
        );
        $response->redirect('/index.php?path=quan-ly/bao-cao');
    }
}