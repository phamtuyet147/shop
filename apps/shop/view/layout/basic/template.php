<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="footer, address, phone, icons"/>
    <title>Christmas Store</title>

    <!-- CSS -->
    <link rel="stylesheet" href="/resources/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/resources/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/resources/css/style.css"/>

    <!-- JS -->
    <script src="/resources/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript"
            src="/resources/js/bootstrap.min.js"></script>
    <script language="javascript" src="/resources/js/common.js"></script>
    <script language="javascript" src="/resources/js/custom.js"></script>
</head>
<body>
<header>
    {w:view header}
</header>
<div class="container-fluid">
    <div class="float-cart">
        <a href="/view-cart"><i class="fa fa-shopping-cart"></i></a>
        <span id="in-cart" class="no-product">{w:action \apps\shop\controller\web\cart\GetCurrentCartState}</span>
    </div>
    <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissable fade in {w:func echo empty($wError) ? 'hide' : '' }">
            <a href="#" class="close" data-dismiss="alert"
               aria-label="close">&times;</a> <strong
                    id="w-error">{w:func echo empty($wError) ? ''
                : $wError }</strong></div>
        <div class="alert alert-success alert-dismissable fade {w:func echo empty($wSuccess) ? 'hide' : '' }">
            <a href="#" class="close" data-dismiss="alert"
               aria-label="close">&times;</a> <strong
                    id="w-success">{w:func echo empty($wSuccess) ? ''
                : $wSuccess }</strong></div>
    </div>
    <div class="col-sm-12">
        {w:view body}
    </div>
</div>
<footer class="container-fluid">
    {w:view footer}
</footer>
</body>
</html>