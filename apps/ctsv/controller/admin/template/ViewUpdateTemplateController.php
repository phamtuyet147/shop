<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/30/2017
 * Time: 4:28 PM
 */

namespace apps\ctsv\controller\admin\template;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\object\Template;
use apps\ctsv\utils\TemplateUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewUpdateTemplateController extends BaseAppController
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
        $template = new Template('', '', '', '');
        $pagePath = $request->getPagePath();
        $templateId = '';
        if (preg_match('/mau-bao-cao\/([a-z0-9]+)/', $pagePath, $match)) {
            $templateId = $match[1];
        }
        if (!empty($templateId)) {
            $template = TemplateUtil::getTemplateById($templateId);
            if (empty($template)) {
                $response->redirect('/index.php?path=quan-ly/mau-bao-cao');
            }
        }
        $request->setAttribute('template', $template);
        $request->setAttribute('templateId', $templateId);
        $appView->doView('success');
    }
}