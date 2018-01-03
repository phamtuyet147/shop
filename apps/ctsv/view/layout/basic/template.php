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
    <link rel="alternate" href="{w:func echo \core\utils\AppInfo::$BASE_URL}"
          hreflang="vi"/>
    <link rel="stylesheet" href="/resources/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/resources/js/jquery-ui/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/resources/css/wStyle.css"/>
    <script type="text/javascript"
            src="/resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/resources/js/common.js"></script>
    <script type="text/javascript" src="/resources/js/main.js"></script>
</head>
<body>
<header class="bg-blue">
    {w:view header}
</header>
<div class="container">
    {w:func if (!empty($error) || !empty($message)) {}
    <div class="width-100 text-center">
        {w:func if (!empty($error)) {}
        <div class="message message-error">{w:func echo $error}</div>
        {/w:func}
        {w:func if (!empty($message)) {}
        <div class="message message-success">{w:func echo $message}</div>
        {/w:func}
    </div>
    {/w:func}
    {w:view body}
</div>
<footer class="bg-blue">
    {w:view footer}
</footer>
</body>
</html>