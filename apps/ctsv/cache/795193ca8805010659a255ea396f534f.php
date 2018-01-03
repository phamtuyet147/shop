<!DOCTYPE html>
<?php /**
 * @var string $error
 * @var string $message
 */
?><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="author" content="Sói Hoang"><title>Báo cáo Công tác sinh viên</title><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="alternate" href="<?php echo \core\utils\AppInfo::$BASE_URL ?>" hreflang="vi"><link rel="stylesheet" href="/resources/css/font-awesome.min.css"><link rel="stylesheet" href="/resources/js/jquery-ui/jquery-ui.min.css"><link rel="stylesheet" href="/resources/css/wStyle.css"><script type="text/javascript" src="/resources/js/jquery-3.2.1.min.js"></script><script type="text/javascript" src="/resources/js/common.js"></script><script type="text/javascript" src="/resources/js/main.js"></script></head><body>
<header class="bg-blue"><?php /**
 * @var User                           $user
 * @var array                          $menu
 * @var int                            $curPageId
 * @var \apps\ctsv\object\ReportYear[] $years
 * @var string                         $activeSchool
 * @var string                         $activeYear
 */

use apps\ctsv\object\User;

?><div class="top-head width-100">
    <div class="width-20">
        <a class="display-block logo" href="/" title="Đại học quốc gia thành phố Hồ Chí Minh">
            <img class="display-block image-resize" src="/resources/images/logo_dhqg.png" alt="Đại học quốc gia thành phố Hồ Chí Minh"></a>
    </div>
    <h1 class="width-80 text-center text-uppercase text-lg">
        BÁO CÁO SỐ LIỆU CÔNG TÁC SINH VIÊN TRỰC TUYẾN
    </h1>
</div>
<nav class="nav-bar">
    <?php $wActionObject = new \apps\ctsv\controller\NavGenerator(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse()); $wActionObject->doGet(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse(), new \core\app\AppView(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse()))?>
</nav>
<?php if (!empty($user)) { ?>
<div id="flat-screen">
    <form method="post" name="UpdateSetting" action="/index.php?path=UpdateSetting.post" class="width-60 width-left-20 vertical-center">
        <fieldset class="fieldset"><legend class="legend">Thay đổi thiết lập phiên làm việc
            </legend>
            <div class="row">
                <div class="width-80 width-left-10">
                    <div class="width-30">
                        Chọn trường
                    </div>
                    <div class="width-70">
                        <select name="school" title="Chọn trường" class="input">
                            <?php foreach ($user->getSchools() as $school) {
                            $selected = '';
                            if ($school->getId() == $activeSchool) {
                            $selected = 'selected'; ?>
                            <?php } ?>
                            <option value="<?php echo $school->getId() ?>"><?php echo $school->getName() ?>
                            </option>
                            <?php } ?>
                        </select></div>
                </div>
            </div>
            <div class="row">
                <div class="width-80 width-left-10">
                    <div class="width-30">
                        Chọn năm báo cáo
                    </div>
                    <div class="width-70">
                        <select name="year" title="Chọn năm báo cáo" class="input"><?php foreach ($years as $year) {
                                $selected = '';
                                if ($year->getId() == $activeYear) {
                                    $selected = 'selected';
                                }
                                ?>
                                <option value="<?php echo $year->getId(
                                ) ?>" echo>>
                                    <?php echo $year->getYearValue() ?>
                                </option><?php } ?></select></div>
                </div>
            </div>
        </fieldset><fieldset class="fieldset"><legend class="legend">Đổi mật khẩu</legend>
            <div class="row">
                <div class="width-80 width-left-10">
                    <div class="width-30">
                        Mật khẩu cũ
                    </div>
                    <div class="width-70">
                        <input type="password" class="input" title="Mật khẩu cũ" name="password_old" value="<?php echo \core\utils\WForm::getFormArgument('UpdateSetting', 'password_old')?>"></div>
                </div>
            </div>
            <div class="row">
                <div class="width-80 width-left-10">
                    <div class="width-30">
                        Mật khẩu mới
                    </div>
                    <div class="width-70">
                        <input type="password" class="input" title="Mật khẩu mới" name="password_new" value="<?php echo \core\utils\WForm::getFormArgument('UpdateSetting', 'password_new')?>"></div>
                </div>
            </div>
            <div class="row">
                <div class="width-80 width-left-10">
                    <div class="width-30">
                        Nhắc lại mật khẩu mới
                    </div>
                    <div class="width-70">
                        <input type="password" class="input" title="Nhắc lại mật khẩu mới" name="password_retype" value="<?php echo \core\utils\WForm::getFormArgument('UpdateSetting', 'password_retype')?>"></div>
                </div>
            </div>
        </fieldset><div class="row text-center">
            <button class="button button-orange">Lưu</button>
            <button class="button button-white" type="button" data-action="hideFlat">Huỷ bỏ
            </button>
        </div>
    <input name="wFrmToken" type="hidden" value="<?php echo \core\utils\WForm::getFormToken('UpdateSetting')?>"></form>
</div>
<?php } ?>

</header><div class="container">
    <?php if (!empty($error) || !empty($message)) { ?>
    <div class="width-100 text-center">
        <?php if (!empty($error)) { ?>
        <div class="message message-error"><?php echo $error ?></div>
        <?php } ?>
        <?php if (!empty($message)) { ?>
        <div class="message message-success"><?php echo $message ?></div>
        <?php } ?>
    </div>
    <?php } ?>
    <form name="LoginForm" id="loginFrm" method="post" class="width-100">
    <div class="row">
        <div class="width-40 text-right">
            Tên đăng nhập
        </div>
        <div class="width-30">
            <input type="text" title="Tên đăng nhập" name="username" class="input" required="required" value="<?php echo \core\utils\WForm::getFormArgument('LoginForm', 'username')?>"></div>
    </div>
    <div class="row">
        <div class="width-40 text-right">
            Mật khẩu
        </div>
        <div class="width-30">
            <input type="password" title="Mật khẩu" name="password" class="input" required="required" value="<?php echo \core\utils\WForm::getFormArgument('LoginForm', 'password')?>"></div>
    </div>
    <div class="row text-center">
        <button class="button" type="submit">Đăng nhập</button>
    </div>
<input name="wFrmToken" type="hidden" value="<?php echo \core\utils\WForm::getFormToken('LoginForm')?>"></form>
</div>
<footer class="bg-blue"><p>Bản quyền thuộc Đại học Quốc gia Thành phố Hồ Chí Minh</p>
</footer><script>                WValidate.setForms({
    "UpdateSetting": [],
    "LoginForm": {
        "@attributes": {
            "name": "LoginForm"
        },
        "field": [
            {
                "@attributes": {
                    "name": "username",
                    "condition": "required"
                },
                "msg": {
                    "@attributes": {
                        "for": "required",
                        "text": "Vui l\u00f2ng nh\u1eadp t\u00ean \u0111\u0103ng nh\u1eadp"
                    }
                }
            },
            {
                "@attributes": {
                    "name": "password",
                    "condition": "required"
                },
                "msg": {
                    "@attributes": {
                        "for": "required",
                        "text": "Vui l\u00f2ng nh\u1eadp m\u1eadt kh\u1ea9u"
                    }
                }
            }
        ]
    }
});
                var EXTERNAL_FRAGMENT;
                WValidate.setDefaultMessage({
    "required": "<?php echo _('Field (1) is required')?>",
    "numeric": "<?php echo _('Field (1) is not a numeric')?>",
    "min": "<?php echo _('Field (1) must be greater than (2)')?>",
    "max": "<?php echo _('Field (1) must be less than (2)')?>",
    "min-length": "<?php echo _('Field (1) must be at least (2) characters')?>",
    "max-length": "<?php echo _('Field (1) could not be longer than (2) characters')?>",
    "pattern": "<?php echo _('Field (1) is not valid')?>",
    "match": "<?php echo _('Fields (1) and (2) are not match')?>",
    "default": "<?php echo _('Fields (1) is not valid')?>"
});
                WValidate.setCustomRules("<wValidator xmlns=\"http:\/\/linhnv.xyz\/w.validator\">\n\n    <rule>\n        <key>phone<\/key>\n        <pattern>\/^\\ ?[0-9]{10,12}$\/<\/pattern>\n    <\/rule>\n    <rule>\n        <key>email<\/key>\n        <pattern>\/^[a-zA-Z0-9-_.] @[a-zA-Z0-9-_.] \\.[a-z]{2,4}$\/i<\/pattern>\n    <\/rule>\n    <rule>\n        <key>ip<\/key>\n        <pattern>\/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$\/gm<\/pattern>\n    <\/rule>\n\n<\/wValidator>");</script></body></html>
