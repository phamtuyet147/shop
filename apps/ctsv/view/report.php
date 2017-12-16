<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/1/2017
 * Time: 6:09 AM
 */
/**
 * @var \apps\ctsv\object\Report $report
 */
$reportTemplate = $report->getTemplate();
if (empty($reportTemplate)) {
    $reportTemplate = new \apps\ctsv\object\Template('', '', '', '');
}
$reportColumns = $reportTemplate->getColumns();
$reportValue = $report->getValue();
$columnMerged = Array();
?>
<form action="/index.php?path=UpdateReportValues.post" method="post"
      class="width-100">
    <div class="row">
        <div class="width-100 text-center text-lg">
            <?php echo $report->getName() ?>
        </div>
    </div>
    <div class="row">
        <div class="width-50">
            <div class="width-50">
                Ngày báo cáo:
            </div>
            <div class="width-50">
                <?php echo $report->getReportDate() ?>
            </div>
        </div>
        <div class="width-50">
            <div class="width-50">
                Hạn báo cáo:
            </div>
            <div class="width-50">
                <?php echo $report->getExpireDate() ?>
            </div>
        </div>
    </div>
    <div class="width-100 table-responsive">
        <table class="table">
            <thead>
            <?php
            $columns = $reportColumns;
            $noRow = 0;
            do {
                $index = 0;
                $noRow++;
                $subColumns = array();
                echo "<tr data-row='{$noRow}'>";
                while ($index < count($columns)) {
                    $column = $columns[$index];
                    echo "<th rowspan='{$column->getRowSpan()}' colspan='{$column->getColSpan()}'>{$column->getName()}</th>";
                    if ($column->getColSpan() > 1) {
                        $noSubColumn = 0;
                        $colSpan = $column->getColSpan();
                        while ($noSubColumn < $colSpan) {
                            $index++;
                            $column = $columns[$index];
                            $subColumns[] = $column;
                            if ($column->getColSpan() == 1) {
                                $noSubColumn++;
                            }
                        }
                    }
                    $index++;
                }
                $columns = $subColumns;
                echo "</tr>";
            } while (!empty($columns));
            ?>
            </thead>
            <tbody id="rows">
            <tr class="hide" id="appendRowHTML">
                <?php foreach ($reportColumns as $column) {
                    if ($column->getColSpan() > 1) {
                        continue;
                    } ?>
                    <td><input title="<?php echo $column->getName() ?>"
                               class="input <?php echo (!$column->isNumeric()
                                   && !$column->isEmpty()) ? 'required' : '' ?>"
                               name="rows[key][<?php echo $column->getColumnKey(
                               ) ?>]"
                            <?php echo ($column->isNumeric())
                                ? 'data-constraint="numeric"' : '' ?>>
                    </td>
                <?php } ?>
                <td class="text-center">
                    <button type="button"
                            class="button button-circle removeRowBtn"
                            title="Xóa cột">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
            <?php
            foreach ($reportValue as $rowId => $row) { ?>
                <tr>
                    <?php
                    foreach ($reportColumns as $column) {
                        if ($column->getColSpan() > 1) {
                            continue;
                        }
                        $value = $row[$column->getColumnKey()];
                        ?>
                        <td><input title="<?php echo $column->getName() ?>"
                                   class="input" value="<?php echo $value ?>"
                                   name="rows[<?php echo $rowId ?>][<?php echo $column->getColumnKey(
                                   ) ?>]"></td>

                        <?php
                    }
                    ?>
                    <td class="text-center">
                        <button type="button" data-action="confirmDelete"
                                class="button button-circle removeRowBtn"
                                title="Xóa dòng">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
                <?php
            } ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="<?php echo count($reportColumns) + 1 ?>"
                    class="text-center">
                    <input type="hidden" class="input" title="Số dòng"
                           id="countRows"
                           value="<?php echo count($reportValue) ?>">
                    <button class="button button-small" title="Thêm dòng"
                            type="button" id="addRowBtn">Thêm dòng
                    </button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="row text-right">
        <input type="hidden" class="input" title="Id" name="id_report"
               value="<?php echo $report->getId() ?>">
        <a href="/index.php?path=/xuat-bao-cao/<?php echo $report->getId() ?>"
           class="button button-orange">Xuất Excel</a>
        <a href="/index.php?path=/nhap-bao-cao/<?php echo $report->getId() ?>"
           class="button">Nhập từ file</a>
        <button class="button button-green">Lưu</button>
    </div>
</form>
<script type="text/javascript" src="/resources/js/updateReport.js"></script>
