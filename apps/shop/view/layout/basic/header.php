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
                {w:action \apps\shop\controller\web\NavGeneratorAction}
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {w:action \apps\shop\controller\web\FetchCustomer}
                <li><a href="/view-cart"<i class="fa fa-shopping-cart"></i>
                    Giỏ hàng</a></li>
            </ul>
        </div>
    </div>
</nav>