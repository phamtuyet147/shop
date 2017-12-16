<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/30/2017
 * Time: 4:27 PM
 */

namespace apps\ctsv\controller\admin\template;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\object\Template;
use apps\ctsv\utils\TemplateUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class UpdateTemplateController extends BaseAppController
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
        $templateId = $request->getParameter('id_template');
        $name = $request->getParameter('name');
        $columns = $request->getParameter('columns');
        if (empty($name) || empty($columns)) {
            $this->raiseError($request, 'Vui lòng nhập đầy đủ thông tin');
            $template = new Template('', '', '', '');
            if (!empty($templateId)) {
                $template = TemplateUtil::getTemplateById($templateId);
                if (empty($template)) {
                    $response->redirect('/index.php?path=quan-ly/mau-bao-cao');
                }
            }
            $request->setAttribute('templateId', $templateId);
            $request->setAttribute('template', $template);
            $appView->doView('error');
        }
        TemplateUtil::updateTemplate($templateId, $name, $columns);
        $response->redirect('/index.php?path=quan-ly/mau-bao-cao');
    }
}