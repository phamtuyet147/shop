<!DOCTYPE html>
<!--suppress ALL --><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="author" content="Sói Hoang"><title><?php echo _('page.title')?></title><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="alternate" href="" hreflang="vi"><link rel="stylesheet" href="/resources/css/font-awesome.min.css"><link rel="stylesheet" href="/resources/css/bootstrap.min.css"><link href="/resources/css/navbar-fixed-side.css" rel="stylesheet"><link rel="stylesheet" href="/resources/css/blog.css"><script type="text/javascript" src="/resources/js/jquery-3.2.1.min.js"></script><script type="text/javascript" src="/resources/js/bootstrap.min.js"></script><script type="text/javascript" src="/resources/js/common.js"></script><script type="text/javascript" src="/resources/js/admin.js"></script></head><body>
<div class="container-fluid">
    <div class="row">
        <header><div class="col-sm-3 col-lg-2">
                <nav class="navbar navbar-inverse navbar-fixed-side"><div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin" title="<?php echo _('page.title')?>">
                <img class="img-responsive" src="/resources/images/logo.svg" onerror="this.src='/resources/images/logo.png'" alt="<?php echo _('page.title')?>">Admin Panel
            </a>
        </div>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav"><li class="dropdown">
                <h2 class="dropdown-toggle text-center">Version: 1.0</h2>
            </li>
            <li class="">
                <a href="/admin/articles"><i class="fa fa-edit"></i>  BÀI VIẾT</a>
            </li>
            <li class="">
                <a href="/admin/guest"><i class="fa fa-check"></i>  DUYỆT THÔNG TIN</a>
            </li>
            <li class="">
                <a href="/admin/members"><i class="fa fa-user"></i>  THÀNH VIÊN</a>
            </li>
        </ul></div>
</nav></div>
        </header><div class="col-sm-9 col-lg-10">
            <div class="col-sm-12">
                <div class="alert alert-danger alert-dismissable fade in <?php echo empty($wError)
                    ? 'hide' : '' ?>">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <strong id="w-error"><?php echo empty($wError)
                            ? '' : $wError ?></strong>
                </div>
                <div class="alert alert-success alert-dismissable fade <?php echo empty($wSuccess)
                    ? 'hide' : '' ?>">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <strong id="w-success"><?php echo empty($wSuccess)
                            ? '' : $wSuccess ?></strong>
                </div>
            </div>
            
        </div>
    </div>
</div>
<footer><p><?php echo _('copyright')?></p>
</footer><script>                WValidate.setForms([]);
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
