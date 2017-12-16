<?php
/**
 * @var \apps\ctsv\object\Template $template
 * @var string                     $templateId
 */
?>
<form action="/index.php?path=UpdateTemplate.post" id="updateTemplateForm"
      method="post" class="width-left-10 width-80">
    <div class="row">
        <div class="width-30">
            Tên mẫu báo cáo
        </div>
        <div class="width-70">
            <input title="Tên báo cáo" class="input"
                   name="name" value="<?php echo $template->getName() ?>"
                   id="name">
        </div>
    </div>
    <div class="row">
        <div class="width-30">
            Các cột dữ liệu
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Tên cột</th>
                <th>Dữ liệu số</th>
                <th>Dữ liệu rỗng</th>
                <th>Ghép dòng</th>
                <th>Ghép cột</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody id="columns">
            <tr class="hide" id="appendColumnHTML">
                <td>
                    <input title="Tên cột"
                           class="input"
                           name="columns[key][name]">
                </td>
                <td class="text-center">
                    <input type="checkbox" title="Dữ liệu số" checked
                           name="columns[key][flag_numeric]">
                </td>
                <td class="text-center">
                    <input type="checkbox" title="Dữ liệu rỗng"
                           name="columns[key][flag_empty]">
                </td>
                <td class="text-center">
                    <input title="Ghép dòng" value="1" class="input text-center"
                           size="1"
                           name="columns[key][row_span]">
                </td>
                <td class="text-center">
                    <input title="Ghép cột" value="1" class="input text-center"
                           size="1"
                           name="columns[key][col_span]">
                </td>
                <td class="text-center">
                    <button type="button"
                            class="button button-circle removeColumnBtn"
                            title="Xóa cột">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
            <?php foreach ($template->getColumns() as $index => $column) {
                ?>
                <tr>
                    <td>
                        <input type="hidden" class="input" title="Tên cột"
                               name="columns[<?php echo $index ?>][column_key]"
                               value="<?php echo $column->getColumnKey() ?>">
                        <input title="Tên cột"
                               class="input"
                               name="columns[<?php echo $index ?>][name]"
                               value="<?php echo $column->getName() ?>">
                    </td>
                    <td class="text-center">
                        <input type="checkbox"
                               title="Dữ liệu số" <?php echo ($column->isNumeric(
                        )) ? 'checked' : '' ?>
                               name="columns[<?php echo $index ?>][flag_numeric]">
                    </td>
                    <td class="text-center">
                        <input type="checkbox"
                               title="Dữ liệu rỗng" <?php echo ($column->isEmpty(
                        )) ? 'checked' : '' ?>
                               name="columns[<?php echo $index ?>][flag_empty]">
                    </td>
                    <td class="text-center">
                        <input title="Ghép dòng"
                               value="<?php echo $column->getRowSpan() ?>"
                               class="input text-center"
                               size="1"
                               name="columns[<?php echo $index ?>][row_span]">
                    </td>
                    <td class="text-center">
                        <input title="Ghép cột"
                               value="<?php echo $column->getColSpan() ?>"
                               class="input text-center"
                               size="1"
                               name="columns[<?php echo $index ?>][col_span]">
                    </td>
                    <td class="text-center">
                        <button type="button" data-action="confirmDelete"
                                class="button button-circle removeColumnBtn"
                                title="Xóa cột">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" class="text-center">
                    <input type="hidden" class="input" title="Số cột"
                           id="countColumns"
                           value="<?php echo count($template->getColumns()) ?>">
                    <button class="button button-small" title="Thêm cột"
                            type="button" id="addColumnBtn">Thêm cột
                    </button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="row text-right">
        <input type="hidden" class="input" title="Id" name="id_template"
               value="<?php echo $templateId ?>">
        <button type="button" id="previewBtn" class="button button-orange">Xem
            trước
        </button>
        <button class="button button-green">Lưu</button>
    </div>
</form>
<div class="width-100 table-responsive">
    <table class="table hide">
        <thead id="previewTable">

        </thead>
    </table>
</div>
<script type="text/javascript" src="/resources/js/updateTemplate.js"></script>