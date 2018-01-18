<?php
/**
 * @var \apps\shop\model\object\Product $product
 */
?>
<h2>Thông tin sản phẩm::<a href="/product/{w:var product->getShortTag()}">{w:text
        product->getTitle()}</a></h2>
<hr>
<div class="product-info">
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-5 thumbnail">
                <img class="img-responsive"
                     src="{w:var product->getThumbnail()[0]}"/>
            </div>
            <div class="col-sm-7">
                <div class="short-desc">
                    {w:text product->getShortDesc()}
                </div>
                <div class="product-btn">
                    <a href="{w:var product->getId()}"
                       class="btn btn-primary btn-add-to-cart"><i
                                class="fa fa-cart-plus"></i>&nbsp;&nbsp;THÊM VÀO
                        GIỎ HÀNG</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="product-detail">
                {w:var product->getDesc()}
            </div>
        </div>
    </div>
</div>