<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/9/2017
 * Time: 5:17 PM
 */

namespace apps\ctsv;


use core\processor\AppMapping;

class Mapping extends AppMapping
{
    protected static $FILTERS
        = Array(
            '/*'         => 'apps\ctsv\controller\CheckLoginFilter',
            '/quan-ly/*' => 'apps\ctsv\controller\CheckAdminPermission',
        );
    protected static $CONTROLLERS
        = Array(
            '/'                        => Array(
                'action' => 'apps\ctsv\controller\HomeController',
                'views'  => Array(
                    'success' => 'Home.view'
                )
            ),
            '/dang-nhap'               => Array(
                'action' => 'apps\ctsv\controller\ViewLoginController',
                'views'  => Array(
                    'success' => 'Login.view'
                )
            ),
            '/VerifyUser.post'         => Array(
                'action' => 'apps\ctsv\controller\LoginController',
                'form'   => 'LoginForm',
                'error'  => '/dang-nhap',
                'views'  => Array(
                    'error' => '/dang-nhap'
                )
            ),
            '/thoat'                   => Array(
                'action' => 'apps\ctsv\controller\LogoutController',
                'views'  => Array(
                    'success' => '/dang-nhap'
                )
            ),
            '/bao-cao'                 => Array(
                'action' => 'apps\ctsv\controller\user\report\ViewReportsController',
                'views'  => Array(
                    'success' => 'Reports.view'
                )
            ),
            '/bao-cao/*'               => Array(
                'action' => 'apps\ctsv\controller\user\report\ViewReportController',
                'views'  => Array(
                    'success' => 'Report.view'
                )
            ),
            '/xuat-bao-cao/*'          => Array(
                'action' => 'apps\ctsv\controller\user\report\ExportReportController',
            ),
            '/quan-ly'                 => Array(
                'action' => 'apps\ctsv\controller\admin\ViewAdminController'
            ),
            '/quan-ly/bao-cao'         => Array(
                'action' => 'apps\ctsv\controller\admin\report\ViewReportsController',
                'views'  => Array(
                    'success' => 'admin/Reports.view'
                )
            ),
            '/quan-ly/truong'          => Array(
                'action' => 'apps\ctsv\controller\admin\school\ViewSchoolsController',
                'views'  => Array(
                    'success' => 'admin/Schools.view'
                )
            ),
            '/quan-ly/tao-bao-cao'     => Array(
                'action' => 'apps\ctsv\controller\admin\report\ViewCreateReportController',
                'views'  => Array(
                    'success' => 'admin/CreateReport.view'
                )
            ),
            '/quan-ly/bao-cao/*'       => Array(
                'action' => 'apps\ctsv\controller\admin\report\ViewUpdateReportController',
                'views'  => Array(
                    'success' => 'admin/UpdateReport.view'
                )
            ),
            '/quan-ly/nam-bao-cao'     => Array(
                'action' => 'apps\ctsv\controller\admin\year\ViewYearsController',
                'views'  => Array(
                    'success' => 'admin/Years.view'
                )
            ),
            '/quan-ly/tai-khoan'       => Array(
                'action' => 'apps\ctsv\controller\admin\account\ViewAccountsController',
                'views'  => Array(
                    'success' => 'admin/Users.view'
                )
            ),
            '/quan-ly/mau-bao-cao'     => Array(
                'action' => 'apps\ctsv\controller\admin\template\ViewTemplatesController',
                'views'  => Array(
                    'success' => 'admin/Templates.view'
                )
            ),
            '/quan-ly/mau-bao-cao/*'   => Array(
                'action' => 'apps\ctsv\controller\admin\template\ViewUpdateTemplateController',
                'views'  => Array(
                    'success' => 'admin/UpdateTemplate.view'
                )
            ),
            '/quan-ly/tao-mau-bao-cao' => Array(
                'action' => 'apps\ctsv\controller\admin\template\ViewUpdateTemplateController',
                'views'  => Array(
                    'success' => 'admin/UpdateTemplate.view'
                )
            ),
            '/quan-ly/tao-tai-khoan'   => Array(
                'action' => 'apps\ctsv\controller\admin\account\ViewUpdateAccountController',
                'views'  => Array(
                    'success' => 'admin/UpdateUser.view'
                )
            ),
            '/quan-ly/tai-khoan/*'     => Array(
                'action' => 'apps\ctsv\controller\admin\account\ViewUpdateAccountController',
                'views'  => Array(
                    'success' => 'admin/UpdateUser.view'
                )
            ),
            '/UpdateSetting.post'      => Array(
                'action' => 'apps\ctsv\controller\user\UpdateSettingController',
            ),
            '/UpdateReportValues.post' => Array(
                'action' => 'apps\ctsv\controller\user\report\UpdateReportValuesController',
                'views'  => Array(
                    'error' => Array(
                        'layout' => 'MainTemplate',
                        'parts'  => Array(
                            'body' => '/view/report.php'
                        )
                    )
                )
            ),
            '/UpdateReportYears.post'  => Array(
                'action' => 'apps\ctsv\controller\admin\year\UpdateYearsController',
                'views'  => Array(
                    'error' => Array(
                        'layout' => 'AdminTemplate',
                        'parts'  => Array(
                            'body' => '/view/admin/reportYears.php'
                        )
                    )
                )
            ),
            '/UpdateSchools.post'      => Array(
                'action' => 'apps\ctsv\controller\admin\school\UpdateSchoolsController',
                'views'  => Array(
                    'error' => Array(
                        'layout' => 'AdminTemplate',
                        'parts'  => Array(
                            'body' => '/view/admin/reportSchools.php'
                        )
                    )
                )
            ),
            '/CreateReport.post'       => Array(
                'action' => 'apps\ctsv\controller\admin\report\CreateReportController',
                'views'  => Array(
                    'error' => Array(
                        'layout' => 'AdminTemplate',
                        'parts'  => Array(
                            'body' => '/view/admin/createReport.php'
                        )
                    )
                )
            ),
            '/UpdateReport.post'       => Array(
                'action' => 'apps\ctsv\controller\admin\report\UpdateReportController',
                'views'  => Array(
                    'error' => Array(
                        'layout' => 'AdminTemplate',
                        'parts'  => Array(
                            'body' => '/view/admin/updateReport.php'
                        )
                    )
                )
            ),
            '/UpdateAccount.post'      => Array(
                'action' => 'apps\ctsv\controller\admin\account\UpdateAccountController',
                'views'  => Array(
                    'error' => Array(
                        'layout' => 'AdminTemplate',
                        'parts'  => Array(
                            'body' => '/view/admin/updateUser.php'
                        )
                    )
                )
            ),
            '/DeleteReport/*'          => Array(
                'action' => 'apps\ctsv\controller\admin\report\DeleteReportController',
            ),
            '/DeleteTemplate/*'        => Array(
                'action' => 'apps\ctsv\controller\admin\template\DeleteTemplateController',
                'views'  => Array(
                    'error' => Array(
                        'layout' => 'AdminTemplate',
                        'parts'  => Array(
                            'body' => '/view/admin/templates.php'
                        )
                    )
                )
            ),
            '/DeleteAccount/*'         => Array(
                'action' => 'apps\ctsv\controller\admin\account\DeleteAccountController',
                'views'  => Array(
                    'error' => Array(
                        'layout' => 'AdminTemplate',
                        'parts'  => Array(
                            'body' => '/view/admin/users.php'
                        )
                    )
                )
            ),
            '/UpdateTemplate.post'     => Array(
                'action' => 'apps\ctsv\controller\admin\template\UpdateTemplateController',
                'views'  => Array(
                    'error' => Array(
                        'layout' => 'AdminTemplate',
                        'parts'  => Array(
                            'body' => '/view/admin/updateTemplate.php'
                        )
                    )
                )
            ),
        );
}