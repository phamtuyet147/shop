<?php
/**
 * @var \apps\shop\model\object\Category[] $categories
 */
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-brand">
            <a href="/" title="Christmas Shop">
                <img class="img-responsive logo"
                     src="/resources/images/nav_logo.png"/>
            </a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            {w:action \apps\shop\controller\web\FetchCustomer}
            <li><a href="/view-cart"<i class="fa fa-shopping-cart"></i>
                Giỏ hàng</a></li>
        </ul>
    </div>
</nav>
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
            <form class="navbar-form navbar-right" action="/search">
                <div class="form-group">
                    <input type="text" class="form-control" name="keyword"
                           placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Tìm</button>
            </form>
        </div>
    </div>
</nav>