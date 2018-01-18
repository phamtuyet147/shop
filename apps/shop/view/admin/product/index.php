<?php
/**
 * @var \apps\shop\model\object\Product[] $products
 */
?>
<h1>Danh mục sản phẩm</h1>
<div class="text-right">
    <a href="/admin/product/create" class="btn btn-success">Thêm sản phẩm</a>
</div>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>STT</th>
            <th>Ảnh thu nhỏ</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Cập nhật</th>
        </tr>
        </thead>
        <tbody>
        {w:func foreach($products as $index => $product){ }
        <tr>
            <td>{w:var index + 1 }</td>
            <td>{w:var product->getThumbnail() }</td>
            <td>{w:var product->getTitle() }</td>
            <td>{w:var product->getPrice() }</td>
            <td align="center">
                <a href="/admin/product/update/{w:var product->getId() }">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="/admin/product/del/{w:var product->getId() }">
                    <i class="fa fa-close"></i>
                </a>
            </td>
        </tr>
        {/w:func}
        </tbody>
    </table>
</div>