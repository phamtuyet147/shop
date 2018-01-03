<?php
/**
 * @var string $error
 * @var string $message
 */

use core\utils\AppInfo;

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Sói Hoang"/>
    <title>{w:var title} | UIT ACM | Cuộc thi lập trình thuật toán sinh
        viên</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="alternate" href="<?php echo AppInfo::$BASE_URL ?>"
          hreflang="vi"/>
    <link rel="stylesheet" href="/resources/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/resources/css/bootstrap.min.css"/>
    <link href="/resources/css/navbar-fixed-side.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/resources/css/wStyle.css"/>
    <script type="text/javascript"
            src="/resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript"
            src="/resources/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/resources/js/common.js"></script>
</head>
<body>
{w:view header}
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <nav class="navbar navbar-inverse navbar-fixed-side">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggle"
                                data-target=".navbar-collapse"
                                data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/admin">Admin Panel</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="">
                                <a href="/admin/contests">CUỘC THI</a>
                            </li>
                            <li class="">
                                <a href="/admin/uit-acm-index">UIT ACM INDEX</a>
                            </li>
                            <li class="">
                                <a href="/admin/members">THÀNH VIÊN</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-sm-9 col-lg-10">
            <div class="col-sm-12" id="message">
                <?php
                if (!empty($error) || !empty($message)) {
                    ?>
                    <div class="width-100 text-center">
                        <?php if (!empty($error)) { ?>
                            <div class="message message-error"><?php echo $error ?></div>
                        <?php } ?>
                        <?php if (!empty($message)) { ?>
                            <div class="message message-success"><?php echo $message ?></div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            {w:view body}
        </div>
    </div>
</div>
{w:view footer}
</body>
</html>