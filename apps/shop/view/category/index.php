<?php
/**
 * @var \apps\shop\model\object\Category  $category
 * @var \apps\shop\model\object\Product[] $products
 */
?>
<h2>Danh mục sản phẩm :: <a
            href="{w:var category->getUrl() }">{w:text category->getTitle() }</a>
</h2>
<hr/>
{w:func foreach ($products as $product) { }
<div class="col-sm-4">
    <div class="panel panel-primary">
        <div class="panel-heading">{w:text product->getTitle() }</div>
        <div class="panel-body text-center">
            <img src="{w:var product->getThumbnail() }"
                 class="img-responsive"/></div>
        <div class="panel-footer">{w:text product->getPrice() }</div>
    </div>
</div>
{/w:func}