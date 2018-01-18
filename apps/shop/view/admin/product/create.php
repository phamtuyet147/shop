<h1>Tạo sản phẩm mới</h1>
<hr>
<form class="form-horizontal" method="post" enctype="multipart/form-data"
      name="CreateProductFrm">
    <div class="col-sm-5">
        <div class="form-group">
            <label class="required col-sm-3" for="id_category">Danh mục</label>
            <div class="col-sm-9">
                <select name="id_category" class="form-control"
                        id="id_category">
                    <option value="">-- Chọn --</option>
                    {w:func foreach ($categories as $category) { }
                    <option value="{w:var category->getId() }">
                        {w:text category->getTitle() }
                    </option>
                    {/w:func}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="required col-sm-3" for="title">Tên sản
                phẩm</label>
            <div class="col-sm-9">
                <input class="form-control" id="title" name="title">
            </div>
        </div>
        <div class="form-group">
            <label class="required col-sm-3" for="price">Giá
                gốc</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" id="price"
                       name="price">
            </div>
        </div>
        <div class="form-group">
            <label class="required col-sm-3" for="short_desc">Mô
                tả ngắn</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="short_desc"
                          name="short_desc"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3" for="pictures">Hình ảnh sản
                phẩm</label>
            <div class="col-sm-9">
                <input type="file" multiple class="form-control" id="pictures"
                       name="pictures[]">
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="form-group">
            <textarea placeholder="Thông tin chi tiết"
                      class="form-control rich-text-editor"
                      id="desc" name="desc"></textarea>
        </div>
    </div>
    <div class="col-sm-12 text-center">
        <a href="/admin/products" class="btn btn-default">Hủy</a>
        <button class="btn btn-primary">Lưu</button>
    </div>
</form>
<script src="/resources/ckeditor/ckeditor.js"></script>
<script src="/resources/js/initCKEditor.js"></script>