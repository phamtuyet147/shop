<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 10/3/2017
 * Time: 6:03 AM
 */

namespace apps\acm\controller\admin;


use apps\acm\Mapping;

class AdminRouting extends Mapping
{
    protected static $CONTROLLERS
        = array(
            '/admin/contests'                  => Array(
                'action' => 'apps\acm\controller\admin\contest\ViewContests',
                'views'  => Array(
                    'success' => '/admin/contests.view'
                )
            ),
            '/admin/contest/view'             => Array(
                'action' => 'apps\acm\controller\admin\contest\ViewContest',
                'views'  => Array(
                    'success' => '/admin/contest.view'
                )
            ),
            '/admin/contest/add'              => Array(
                'action' => 'apps\acm\controller\admin\contest\ViewAddContest',
                'views'  => Array(
                    'success' => '/admin/contest/view',
                    'submit'  => '/admin/contest/AddContest.post'
                )
            ),
            '/admin/contest/edit'             => Array(
                'action' => 'apps\acm\controller\admin\contest\ViewEditContest',
                'views'  => Array(
                    'success' => '/admin/contest/view',
                    'submit'  => '/admin/contest/EditContest.post'
                )
            ),
            '/admin/contest/del'              => Array(
                'action' => 'apps\acm\controller\admin\contest\DeleteContest',
                'views'  => Array(
                    'success' => '/admin/contests',
                )
            ),
            '/admin/contest/AddContest.post'  => Array(
                'action' => 'apps\acm\controller\admin\contest\AddContest',
                'form'   => 'UpdateContest',
                'error'  => '/admin/contest/view',
                'views'  => Array(
                    'success' => '/admin/contests'
                )
            ),
            '/admin/contest/EditContest.post' => Array(
                'action' => 'apps\acm\controller\admin\contest\EditContest',
                'form'   => 'UpdateContest',
                'error'  => '/admin/contest/view',
                'views'  => Array(
                    'success' => '/admin/contest/view'
                )
            ),
        );
}