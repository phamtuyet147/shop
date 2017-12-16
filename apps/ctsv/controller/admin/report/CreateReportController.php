<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/30/2017
 * Time: 3:38 PM
 */

namespace apps\ctsv\controller\admin\report;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\ReportUtil;
use apps\ctsv\utils\SchoolUtil;
use apps\ctsv\utils\TemplateUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class CreateReportController extends BaseAppController
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
        $name = $request->getParameter('name');
        $yearId = $request->getParameter('id_year');
        $schools = $request->getParameter('schools');
        $expireDate = $request->getParameter('dt_expire');
        $templateId = $request->getParameter('id_template');
        if (empty($name) || empty($yearId) || empty($schools)
            || empty($expireDate)
            || empty($templateId)
        ) {
            $templates = TemplateUtil::getTemplates();
            $years = $request->getSession('years');
            $schools = SchoolUtil::getAllSchoolsInfo();
            $request->setAttribute('templates', $templates);
            $request->setAttribute('years', $years);
            $request->setAttribute('schools', $schools);
            $this->raiseError($request, 'Vui lòng nhập đầy đủ thông tin');
            $appView->doView('error');
        }
        ReportUtil::createReport(
            $name, $templateId, $yearId, $schools, $expireDate
        );
        $response->redirect('/index.php?path=quan-ly/bao-cao');
    }
}