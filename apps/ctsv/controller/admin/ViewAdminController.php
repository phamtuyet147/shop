<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/22/2017
 * Time: 6:39 AM
 */

namespace apps\ctsv\controller\admin;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\SchoolUtil;
use apps\ctsv\utils\TemplateUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewAdminController extends BaseAppController
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
        $response->redirect('/index.php?path=quan-ly/bao-cao');
    }
}