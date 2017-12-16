<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/23/2017
 * Time: 11:06 AM
 */

namespace apps\ctsv\controller\admin\report;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\SchoolUtil;
use apps\ctsv\utils\TemplateUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewCreateReportController extends BaseAppController
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
        $appView->doView('success');
    }
}