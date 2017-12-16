<?php
/**
 * @var string $error
 * @var string $message
 */

use core\utils\AppInfo;

?>
<!doctype html>
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
    <link rel="stylesheet" href="/resources/css/acm.css"/>
    <script type="text/javascript"
            src="/resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript"
            src="/resources/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/resources/js/common.js"></script>
</head>
<body>
{w:view header}
<div class="container-fluid">
    <?php if (!empty($sidebar)){ ?>
    <div class="col-sm-9">
        <?php } ?>
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
        <?php if (!empty($sidebar)){ ?>
    </div>
    <div class="col-sm-3">
        {w:view sidebar}
    </div>
<?php }
?>
</div>
{w:view footer}
</body>
</html>