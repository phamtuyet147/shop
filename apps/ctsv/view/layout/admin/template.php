<?php
/**
 * @var string $error
 * @var string $message
 */
?>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Sói Hoang"/>
    <title>Báo cáo Công tác sinh viên</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="alternate" href="<?php echo \core\utils\AppInfo::$BASE_URL ?>"
          hreflang="vi"/>
    <link rel="stylesheet" href="/resources/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/resources/js/jquery-ui/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/resources/css/wStyle.css"/>
    <script type="text/javascript"
            src="/resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript"
            src="/resources/js/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/resources/js/main.js"></script
</head>
<body>
<header class="bg-blue">
    {w:view header}
</header>
<div class="container">
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
    <div class="width-30">
        <div class="box">
            <div class="box-heading">
                Quản lý
            </div>
            <div class="box-body">
                <div class="list-group">
                    <a href="/index.php?path=quan-ly/bao-cao" class="list-item">
                        Báo cáo
                    </a>
                    <a href="/index.php?path=quan-ly/tai-khoan"
                       class="list-item">
                        Tài khoản
                    </a>
                    <a href="/index.php?path=quan-ly/nam-bao-cao"
                       class="list-item">
                        Năm báo cáo
                    </a>
                    <a href="/index.php?path=quan-ly/truong" class="list-item">
                        Danh sách trường
                    </a>
                    <a href="/index.php?path=quan-ly/mau-bao-cao"
                       class="list-item">
                        Mẫu báo cáo
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="width-70">
        {w:view body}
    </div>
</div>
<footer class="bg-blue">
    {w:view footer}
</footer>
</body>
</html>