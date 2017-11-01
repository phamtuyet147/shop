<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/9/2017
 * Time: 5:17 PM
 */

namespace apps\acm;


use core\app\Route;

class Mapping extends Route
{
    protected static $ROUTE_MAPPINGS
        = Array(
            '/admin/*' => 'apps\acm\controller\admin\AdminRouting'
        );

    protected static $FILTERS
        = Array();

    protected static $CONTROLLERS
        = Array(
            '/'             => Array(
                'action' => 'apps\acm\controller\basic\Home',
                'views'  => Array(
                    'success' => 'Home.view'
                )
            ),
            '/admin'        => Array(
                'action' => 'apps\acm\controller\admin\Home',
                'views'  => Array(
                    'success' => 'AdminHome.view'
                )
            ),
            '/contest/info' => Array(
                'action' => 'apps\acm\controller\basic\ViewContestInfo',
                'views'  => Array(
                    'success' => 'Contest.view'
                )
            )
        );
}