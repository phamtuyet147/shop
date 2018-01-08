<?php
/**
 * @var \apps\shop\model\object\Category[] $categories
 */
?>
<div class="row bg-danger">
    <div class="col-3">
        <div class="img">
            <img src="/resources/images/nav_logo.png">
        </div>
    </div>
    <form action="#" class="col-4">
        <div class="col-7">
            <input class="input" type="text" placeholder="Chọn sản phẩm cần tìm"
                   name="search">
        </div>
        <button id="btn" class="btn" type="submit"><i class="fa fa-search"
                                                      aria-hidden="true">search</i>
        </button>
    </form>
    <div class="col-3 text-right">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        <img src=""/>
        <a href="">Đăng nhập</a>
    </div>
</div>
<div class="row bg-success">
    {w:action \apps\shop\controller\web\NavGeneratorAction}
</div>