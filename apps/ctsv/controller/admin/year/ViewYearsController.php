<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/26/2017
 * Time: 9:34 PM
 */

namespace apps\ctsv\controller\admin\year;


use apps\ctsv\controller\BaseAppController;
use core\processor\AppView;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;

class ViewYearsController extends BaseAppController
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
        $years = $request->getSession('years');
        $request->setAttribute('reportYears', $years);
        $appView->doView('success');
    }
}