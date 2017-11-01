<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 9/13/17
 * Time: 5:41 PM
 */

namespace apps\acm;


use core\app\View;

class Views extends View
{
    protected static $LAYOUTS
        = Array(
            'MainTemplate'  => Array(
                'layout' => '/view/layout/basic/template.php',
                'parts'  => Array(
                    'header'  => '/view/layout/basic/header.php',
                    'body'    => '/view/layout/blank.php',
                    'sidebar' => '/view/layout/basic/sidebar.php',
                    'footer'  => '/view/layout/basic/footer.php'
                )
            ),
            'AdminTemplate' => Array(
                'layout' => '/view/layout/admin/template.php',
                'parts'  => Array(
                    'header' => '/view/layout/admin/header.php',
                    'body'   => '/view/layout/blank.php',
                    'footer' => '/view/layout/admin/footer.php'
                )
            )
        );

    protected static $VIEWS
        = Array(
            'Home.view'      => Array(
                'layout' => 'MainTemplate',
                'parts'  => Array(
                    'body'      => '/view/home.php',
                    'acm_index' => '/view/home_context/acm_index.html',
                    'introduce' => '/view/home_context/introduce.html',
                    'rule'      => '/view/home_context/rule.html'
                )
            ),
            'AdminHome.view' => Array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/home.php',
                )
            ),
            '/admin/contests.view' => array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/contest/index.php',
                )
            ),
            '/admin/contest.view' => array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/contest/update.php',
                )
            ),
            'Contest.view'   => Array(
                'layout' => 'MainTemplate',
                'parts'  => Array(
                    'body' => '/view/contest.php',
                )
            ),
        );
}