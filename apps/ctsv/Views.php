<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 9/13/17
 * Time: 5:41 PM
 */

namespace apps\ctsv;


use core\processor\AppView;

class Views extends AppView
{
    protected static $LAYOUTS
        = Array(
            'MainTemplate'  => Array(
                'layout' => '/view/layout/basic/template.php',
                'parts'  => Array(
                    'header' => '/view/layout/header.php',
                    'body'   => '/view/layout/blank.php',
                    'footer' => '/view/layout/footer.php'
                )
            ),
            'AdminTemplate' => Array(
                'layout' => '/view/layout/admin/template.php',
                'parts'  => Array(
                    'header' => '/view/layout/header.php',
                    'body'   => '/view/layout/blank.php',
                    'footer' => '/view/layout/footer.php'
                )
            )
        );

    protected static $FORMS
        = Array(
            'LoginForm' => Array(
                'username' => Array(
                    Array(
                        'condition' => 'required',
                        'message'   => 'Vui lòng nhập tên đăng nhập'
                    )
                ),
                'password' => Array(
                    Array(
                        'condition' => 'required',
                        'message'   => 'Vui lòng nhập mật khẩu'
                    )
                ),
            ),
        );

    protected static $VIEWS
        = Array(
            'Home.view'                 => Array(
                'layout' => 'MainTemplate',
                'parts'  => Array(
                    'body' => '/view/home.php'
                )
            ),
            'Login.view'                => Array(
                'layout' => 'MainTemplate',
                'parts'  => Array(
                    'body' => '/view/login.php'
                )
            ),
            'Reports.view'              => Array(
                'layout' => 'MainTemplate',
                'parts'  => Array(
                    'body' => '/view/reports.php'
                )
            ),
            'Report.view'               => Array(
                'layout' => 'MainTemplate',
                'parts'  => Array(
                    'body' => '/view/report.php'
                )
            ),
            'admin/Reports.view'        => Array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/reports.php'
                )
            ),
            'admin/Schools.view'        => Array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/reportSchools.php'
                )
            ),
            'admin/CreateReport.view'   => Array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/createReport.php'
                )
            ),
            'admin/UpdateReport.view'   => Array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/updateReport.php'
                )
            ),
            'admin/Years.view'          => Array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/reportYears.php'
                )
            ),
            'admin/Users.view'          => Array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/users.php'
                )
            ),
            'admin/Templates.view'      => Array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/templates.php'
                )
            ),
            'admin/UpdateTemplate.view' => Array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/updateTemplate.php'
                )
            ),
            'admin/UpdateUser.view' => Array(
                'layout' => 'AdminTemplate',
                'parts'  => Array(
                    'body' => '/view/admin/updateUser.php'
                )
            )
        );
}