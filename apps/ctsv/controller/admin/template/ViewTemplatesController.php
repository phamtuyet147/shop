<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/30/2017
 * Time: 4:08 PM
 */

namespace apps\ctsv\controller\admin\template;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\TemplateUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewTemplatesController extends BaseAppController
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
        $templates = TemplateUtil::getTemplates();
        $request->setAttribute('templates', $templates);
        $appView->doView('success');
    }
}