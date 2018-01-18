<h2>Xem giỏ hàng</h2>
<hr>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Cập nhật</th>
        </tr>
        </thead>
        <tbody>
        {w:func foreach($products as $index => $product){ }
        <tr>
            <td>{w:var index + 1 }</td>
            <td>{w:var product->getTitle() }</td>
            <td>{w:var product->getPrice() }</td>
            <td align="center">
                <a href="/admin/product/del/{w:var product->getId() }">
                    <i class="fa fa-close"></i>
                </a>
            </td>
        </tr>
        {/w:func}
        </tbody>
    </table>
</div>