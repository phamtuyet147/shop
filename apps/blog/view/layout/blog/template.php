<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Sói Hoang"/>
    <title>{w:msg page.title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="alternate" href="<?= \core\utils\AppInfo::$BASE_URL ?>" hreflang="vi"/>
    <link rel="stylesheet" href="/resources/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/resources/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/resources/css/blog.css"/>
    <script type="text/javascript" src="/resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/resources/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/resources/js/common.js"></script>
</head>
<body>
<header>
    {w:view header}
</header>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            {w:view body}
        </div>
        <div class="col-sm-3">
            <a href="/guest/post" class="btn btn-primary btn-block">{w:msg guestPost}</a>
            <div class="panel panel-default">
                <div class="panel-heading text-center">{w:msg author}</div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="col-sm-10 col-sm-offset-1">
                            <img class="img-responsive"
                                 src="/resources/images/sh.jpg"
                                 alt="{w:msg author}"/>
                        </div>
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
<footer>
    {w:view footer}
</footer>
</body>
</html>