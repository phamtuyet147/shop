<?php
/**
 * @var \apps\blog\model\object\Label[] $labels
 */
?>
<div class="row">
    <div class="col-sm-10">
        <h4>
            <i class="fa fa-plus"></i>&nbsp;&nbsp;VIẾT BÀI MỚI
        </h4>
    </div>
</div>
<hr>
<div id="createLabel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form class="modal-content form-horizontal" name="CreateLabel"
              id="CreateLabel">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">Tạo nhãn</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-2"
                           for="label">Nhãn:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="label" name="label"
                               placeholder="Nhập tên nhãn">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">Đóng
                </button>
            </div>
        </form>

    </div>
</div>
<link rel="stylesheet" href="/resources/css/select2.min.css"/>
<link rel="stylesheet" href="/resources/editor/css/editormd.min.css"/>
<div class="col-sm-12">
    <form class="form-horizontal" name="UpdateArticle">
        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input name="title" id="title" class="form-control">
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <label for="labels">Nhãn</label>
                </div>
                <div class="col-sm-10">
                    <select data-placeholder="Chọn nhãn" multiple
                            class="form-control chosen-select" id="labels"
                            name="labels">
                        <?php foreach ($labels as $label) { ?>
                            <option value="<?php echo $label->getTag() ?>">
                                <?php echo $label->getTitle() ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#createLabel">Tạo nhãn
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="content">Nội dung</label>
            <div id="editormd">
                <textarea id="content" name="content" class="hide"
                          placeholder="Nội dung"></textarea>
            </div>
        </div>
        <div class="form-group text-right">
            <button class="btn btn-primary">Lưu</button>
            <a href="/admin/articles" class="btn btn-default">Huỷ bỏ</a>
        </div>
    </form>
</div>
<script src="/resources/js/select2.min.js"></script>
<script src="/resources/editor/editormd.min.js"></script>
<script src="/resources/editor/languages/en.js"></script>