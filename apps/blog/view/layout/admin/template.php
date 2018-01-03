<!doctype html>
<!--suppress ALL -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Sói Hoang"/>
    <title>{w:msg page.title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="alternate" href=""
          hreflang="vi"/>
    <link rel="stylesheet" href="/resources/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/resources/css/bootstrap.min.css"/>
    <link href="/resources/css/navbar-fixed-side.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/resources/css/blog.css"/>
    <script type="text/javascript"
            src="/resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript"
            src="/resources/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/resources/js/common.js"></script>
    <script type="text/javascript" src="/resources/js/admin.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <header>
            <div class="col-sm-3 col-lg-2">
                {w:view header}
            </div>
        </header>
        <div class="col-sm-9 col-lg-10">
            <div class="col-sm-12">
                <div class="alert alert-danger alert-dismissable fade in {w:func echo empty($wError)
                    ? 'hide' : '' }">
                    <a href="#" class="close" data-dismiss="alert"
                       aria-label="close">&times;</a>
                    <strong id="w-error"><?php echo empty($wError)
                            ? '' : $wError ?></strong>
                </div>
                <div class="alert alert-success alert-dismissable fade {w:func echo empty($wSuccess)
                    ? 'hide' : '' }">
                    <a href="#" class="close" data-dismiss="alert"
                       aria-label="close">&times;</a>
                    <strong id="w-success"><?php echo empty($wSuccess)
                            ? '' : $wSuccess ?></strong>
                </div>
            </div>
            {w:view body}
        </div>
    </div>
</div>
<footer>
    {w:view footer}
</footer>
</body>
</html>