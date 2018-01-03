<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="author" content="Sói Hoang"><title><?php echo _('page.title')?></title><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="alternate" href="" hreflang="vi"><link rel="stylesheet" href="/resources/css/font-awesome.min.css"><link rel="stylesheet" href="/resources/css/bootstrap.min.css"><link rel="stylesheet" href="/resources/css/blog.css"><script type="text/javascript" src="/resources/js/jquery-3.2.1.min.js"></script><script type="text/javascript" src="/resources/js/bootstrap.min.js"></script><script type="text/javascript" src="/resources/js/common.js"></script></head><body>
<header><nav class="navbar navbar-inverse"><div class="container-fluid">
        <div class="navbar-header">
            <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" title="<?php echo _('page.title')?>">
                <img class="navbar-brand" src="/resources/images/logo.svg" onerror="this.src='/resources/images/logo.png'" alt="<?php echo _('page.title')?>" style="padding: 0"></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right"><li>
                    <a href="/" title="<?php echo _('home')?>">
                        <i class="fa fa-home"></i> 
                        <span class="nav-text"><?php echo _('Home')?></span>
                    </a>
                </li>
                <li>
                    <a href="http://wcode.vn" title="<?php echo _('code')?>">
                        <i class="fa fa-code"></i> 
                        <span class="nav-text"><?php echo _('wCode')?></span>
                    </a>
                </li>
            </ul></div>
    </div>
</nav></header><div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <form name="TestForm" method="post">
    <input title="field1" name="field1" value=""><input title="field2" name="field2" value="<?php echo \core\utils\WForm::getFormArgument('TestForm', 'field2')?>" required="required"><input title="field3" name="field3" value="<?php echo \core\utils\WForm::getFormArgument('TestForm', 'field3')?>"><input type="radio" title="field4" name="field4" value="1" <?php echo \core\utils\WForm::getFormArgument('TestForm', 'field4') == '1' ? 'checked' : ''?>><input type="radio" title="field4" name="field4" value="2" <?php echo \core\utils\WForm::getFormArgument('TestForm', 'field4') == '2' ? 'checked' : ''?>><button>Submit</button>
<input name="wFrmToken" type="hidden" value="<?php echo \core\utils\WForm::getFormToken('TestForm')?>"></form>
<?php if(empty($a)){ ?>
=jkuyasfuidhsaj
<?php } ?>
        </div>
        <div class="col-sm-3">
            <a href="/guest/post" class="btn btn-primary btn-block"><?php echo _('guestPost')?></a>
            <div class="panel panel-default">
                <div class="panel-heading text-center"><?php echo _('author')?></div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="col-sm-10 col-sm-offset-1">
                            <img class="img-responsive" src="/resources/images/sh.jpg" alt="<?php echo _('author')?>"></div>
                    </div>
                    <div class="text-center">
                        <p>
                            Learn to share, and share to learn...
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer><p><?php echo _('copyright')?></p>
</footer><script>                WValidate.setForms({
    "TestForm": "<form xmlns=\"http:\/\/linhnv.xyz\/forms\" name=\"TestForm\">\n        <field name=\"field1\" condition=\"phone\" recover=\"false\">\n            <msg for=\"required\" text=\"Vui lòng nhập Tiêu đề\"\/>\n        <\/field>\n        <field name=\"field2\" condition=\"required\">\n            <msg for=\"required\" text=\"Vui lòng nhập Nội dung\"\/>\n        <\/field>\n    <\/form>"
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
                WValidate.setCustomRules("<wValidator xmlns=\"http:\/\/linhnv.xyz\/w.validator\">\n\n    <rule>\n        <key>phone<\/key>\n        <pattern>\/^\\+?[0-9]{10,12}$\/<\/pattern>\n    <\/rule>\n    <rule>\n        <key>email<\/key>\n        <pattern>\/^[a-zA-Z0-9-_.]+@[a-zA-Z0-9-_.]+\\.[a-z]{2,4}$\/i<\/pattern>\n    <\/rule>\n    <rule>\n        <key>ip<\/key>\n        <pattern>\/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$\/gm<\/pattern>\n    <\/rule>\n\n<\/wValidator>");</script></body></html>
