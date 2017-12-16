<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/26/2017
 * Time: 9:34 PM
 */

namespace apps\ctsv\controller\admin\school;


use apps\ctsv\controller\BaseAppController;
use apps\ctsv\utils\SchoolUtil;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewSchoolsController extends BaseAppController
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
        $schools = SchoolUtil::getAllSchoolsInfo();
        $request->setAttribute('schools', $schools);
        $appView->doView('success');
    }
}