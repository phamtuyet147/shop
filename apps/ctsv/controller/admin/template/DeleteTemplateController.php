<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/2/2017
 * Time: 6:02 PM
 */

namespace apps\ctsv\controller\admin\template;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\TemplateUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class DeleteTemplateController extends BaseAppController
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
        $pagePath = $request->getPagePath();
        $templateId = '';
        if (preg_match('/DeleteTemplate\/([a-z0-9]+)/', $pagePath, $match)) {
            $templateId = $match[1];
        }
        if (empty($templateId)) {
            $response->redirect('/');
        }
        $template = TemplateUtil::getTemplateById($templateId);
        if (empty($template)) {
            $this->raiseError($request, 'Không tìm thấy mẫu báo cáo');
            $templates = TemplateUtil::getTemplates();
            $request->setAttribute('templates', $templates);
            $appView->doView('error');
        }
        $report = TemplateUtil::getReportInUseByTemplateId($templateId);
        if (!empty($report)) {
            $this->raiseError(
                $request,
                'Mẫu này hiện đang được sử dụng, vui lòng xoá các báo cáo trước khi xoá mẫu này'
            );
            $templates = TemplateUtil::getTemplates();
            $request->setAttribute('templates', $templates);
            $appView->doView('error');
        }
        $delete = TemplateUtil::deleteTemplate($templateId);
        if (!$delete) {
            $response->redirect('/');
        }
        $response->redirect('/index.php?path=quan-ly/mau-bao-cao');
    }
}