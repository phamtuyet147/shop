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
    <?php
/**
 * @var \apps\shop\model\object\Category[] $categories
 */
?>
<div class="jumbotron">
    <div class="container text-center">
        <h1>Christmas Store</h1>
        <p>Chuyên cung cấp sỉ & lẻ các sản phẩm đón Noel</p>
    </div>
</div>
<nav class="navbar navbar-default navbar-christmas">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="/">Trang chủ</a></li>
                <?php $wActionObject = new \apps\shop\controller\web\NavGeneratorAction(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse()); $wActionObject->doGet(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse(), new \core\app\AppView(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse()))?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php $wActionObject = new \apps\shop\controller\web\FetchCustomer(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse()); $wActionObject->doGet(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse(), new \core\app\AppView(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse()))?>
                <li><a href="/view-cart"<i class="fa fa-shopping-cart"></i>
                    Giỏ hàng</a></li>
            </ul>
        </div>
    </div>
</nav>
</header>
<div class="container-fluid">
    <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissable fade in <?php echo empty($wError) ? 'hide' : '' ?>">
            <a href="#" class="close" data-dismiss="alert"
               aria-label="close">&times;</a> <strong
                    id="w-error"><?php echo empty($wError) ? ''
                : $wError ?></strong></div>
        <div class="alert alert-success alert-dismissable fade <?php echo empty($wSuccess) ? 'hide' : '' ?>">
            <a href="#" class="close" data-dismiss="alert"
               aria-label="close">&times;</a> <strong
                    id="w-success"><?php echo empty($wSuccess) ? ''
                : $wSuccess ?></strong></div>
    </div>
    <div class="col-sm-12">
        <div id="shopSlide" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#shopSlide" data-slide-to="0" class="active"></li>
        <li data-target="#shopSlide" data-slide-to="1"></li>
        <li data-target="#shopSlide" data-slide-to="2"></li>
        <li data-target="#shopSlide" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <img src="/resources/images/slide/1.jpg" alt="Quà tặng giáng sinh"/>
        </div>
        <div class="item">
            <img src="/resources/images/slide/2.jpg" alt="Quà tặng giáng sinh"/>
        </div>
        <div class="item">
            <img src="/resources/images/slide/3.jpg" alt="Quà tặng giáng sinh"/>
        </div>
        <div class="item">
            <img src="/resources/images/slide/4.jpg" alt="Quà tặng giáng sinh"/>
        </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#shopSlide" data-slide="prev">
        <i class="fa fa-angle-left"></i>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#shopSlide" data-slide="next">
        <i class="fa fa-angle-right"></i>
        <span class="sr-only">Next</span>
    </a>
</div>
    </div>
</div>
<footer class="container-fluid">
    <div class="col-sm-4">
    <b>GIẢI ĐÁP THÔNG TIN.</b><br>
    <p>Liên hệ : Trường đại học công nghệ thông tin , Khu phố 6, phường Linh
        Trung ,quận Thủ Đức, tp. HCM</p>
    <p>Số điện thoại : 1900-82234-4754</p>
    <a href="">Hướng dấn đổi trả.</a>
</div>
<div class="col-sm-4">
    <p>
        <a href="#" class="brand-circle">
            <i class="fa fa-facebook" aria-hidden="true"></i></a>
        <a href="#" class="brand-circle">
            <i class="fa fa-google-plus" aria-hidden="true"></i></a>
        <a href="#" class="brand-circle">
            <i class="fa fa-twitter" aria-hidden="true"></i></a>
    </p>
    <form class="form-inline">Get deals:
        <input type="email" class="form-control" size="50"
               placeholder="Email Address">
        <button type="button" class="btn btn-danger">Sign Up</button>
    </form>
</div>
<div class="col-sm-4">
    <img src="/resources/images/nav_logo.png">
    <b>HỆ THỐNG CÁC CỬA HÀNG :</b>
    <ul>
        <li>Cơ sở 1 : Khu phố 6, phường Linh Trung ,quận Thủ Đức, tp. HCM</li>
        <li>Cơ sở 2 : Khu phố 6, phường Linh Trung ,quận Thủ Đức, tp. HCM</li>
        <li>Cơ sở 3 : Khu phố 6, phường Linh Trung ,quận Thủ Đức, tp. HCM</li>
        <li>Cơ sở 4 : Khu phố 6, phường Linh Trung ,quận Thủ Đức, tp. HCM</li>
    </ul>
</div>
</footer>
                <script type="text/javascript">
                WValidate.setForms([]);
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
                WValidate.setCustomRules("<wValidator xmlns=\"http:\/\/linhnv.xyz\/w.validator\">\n\n    <rule>\n        <key>phone<\/key>\n        <pattern>\/^\\+?[0-9]{10,12}$\/<\/pattern>\n    <\/rule>\n    <rule>\n        <key>email<\/key>\n        <pattern>\/^[a-zA-Z0-9-_.]+@[a-zA-Z0-9-_.]+\\.[a-z]{2,4}$\/i<\/pattern>\n    <\/rule>\n    <rule>\n        <key>ip<\/key>\n        <pattern>\/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$\/gm<\/pattern>\n    <\/rule>\n\n<\/wValidator>");
                </script></body>
</html>