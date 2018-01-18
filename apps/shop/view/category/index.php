<?php
/**
 * @var \apps\shop\model\object\Category  $category
 * @var \apps\shop\model\object\Product[] $products
 */
?>
<h2>Danh mục sản phẩm :: <a
            href="{w:var category->getUrl() }">{w:text category->getTitle()
        }</a>
</h2>
<hr/>
{w:func foreach ($products as $product) { }
<div class="col-sm-3">
    <div class="product">
        <img src="{w:var product->getThumbnail() }"
             class="img-responsive"/>
        <div class="product-info">
            <h4>
                <a href="/product/{w:var product->getShortTag() }">{w:text
                    product->getTitle() }</a>
            </h4>
            <div class="product-short-desc">{w:text product->getShortDesc()
                }
            </div>
            <div class="product-footer">
                {w:text product->getPrice() }
                <div class="pull-right">
                    <a href="{w:var product->getId()}"
                       class="product-cart btn-add-to-cart"><i
                                class="fa fa-cart-plus"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
{/w:func}