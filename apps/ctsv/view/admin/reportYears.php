<?php
/**
 * @var \apps\ctsv\object\ReportYear[] $reportYears
 */
?>
<form action="/index.php?path=UpdateReportYears.post" method="post">
    <table class="table non-top">
        <thead>
        <tr>
            <th>STT</th>
            <th>Năm báo cáo</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $index = 0;
        foreach ($reportYears as $index => $reportYear) {
            ?>
            <tr id="row-<?php echo $reportYear->getId() ?>">
                <td>
                    <?php echo $index + 1 ?>
                    <input type="hidden" class="input"
                           name="years[<?php echo $index ?>][id]"
                           title="Id"
                           value="<?php echo $reportYear->getId() ?>">
                </td>
                <td><input type="text" class="input"
                           name="years[<?php echo $index ?>][value]"
                           title="Năm báo cáo"
                           value="<?php echo $reportYear->getYearValue() ?>">
                </td>
                <td class="text-center">
                    <a href="<?php echo $reportYear->getId() ?>"
                       class="removeRowBtn text-lg" title="Xóa dòng"
                       data-action="confirmDelete"><i
                                class="fa fa-times-circle"></i></a>
                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td><input type="hidden" class="input"
                       name="years[<?php echo $index + 1 ?>][id]"
                       title="Id"
                       value=""></td>
            <td><input type="text" class="input"
                       name="years[<?php echo $index + 1 ?>][value]"
                       title="Năm báo cáo"
                       value=""></td>
            <td>

            </td>
        </tr>
        </tbody>
    </table>
    <div class="width-100 text-center">
        <button class="button" name="updateYears" id="updateYears"
                title="Cập nhật năm báo cáo" type="submit">Lưu
        </button>
    </div>
</form>