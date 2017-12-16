<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/2/2017
 * Time: 9:20 PM
 */
/**
 * @var \apps\ctsv\object\ReportYear[] $years
 * @var \apps\ctsv\object\School[]     $schools
 * @var \apps\ctsv\object\Template[]   $templates
 * @var \apps\ctsv\object\Report       $report
 */
$reportTemplate = $report->getTemplate();
$reportYear = $report->getYear();
$reportSchool = $report->getSchool();
?>
<form action="/index.php?path=UpdateReport.post" method="post"
      class="width-left-10 width-80">
    <div class="row">
        <div class="width-30">
            Mẫu báo cáo
        </div>
        <div class="width-70">
            <select name="id_template" class="input" title="Mẫu báo cáo">
                <?php foreach ($templates as $template) {
                    $selected = '';
                    if ($template->getId() == $reportTemplate->getId()) {
                        $selected = 'selected';
                    }
                    ?>
                    <option value="<?php echo $template->getId(
                    ) ?>" <?php echo $selected ?>>
                        <?php echo $template->getName() ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="width-30">
            Tên báo cáo
        </div>
        <div class="width-70">
            <input title="Tên báo cáo" class="input"
                   name="name" value="<?php echo $report->getName() ?>"
                   id="name">
        </div>
    </div>
    <div class="row">
        <div class="width-30">
            Năm báo cáo
        </div>
        <div class="width-70">
            <select name="id_year" class="input" title="Năm báo cáo">
                <?php foreach ($years as $year) {
                    $selected = '';
                    if ($year->getId() == $reportYear->getId()) {
                        $selected = 'selected';
                    }
                    ?>
                    <option value="<?php echo $year->getId(
                    ) ?>" <?php echo $selected ?>>
                        <?php echo $year->getYearValue() ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="width-30">
            Chọn trường
        </div>
        <div class="width-70">
            <?php foreach ($schools as $school) {
                $checked = '';
                if ($school->getId() == $reportSchool->getId()) {
                    $checked = 'checked';
                }
                ?>
                <div class="row">
                    <label>
                        <input type="checkbox" name="schools[]"
                               disabled <?php echo $checked ?>
                               value="<?php echo $school->getId() ?>">
                        <?php echo $school->getName() ?>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="width-30">
            Ngày hết hạn báo cáo
        </div>
        <div class="width-70">
            <input title="Hạn báo cáo"
                   value="<?php echo $report->getExpireDate() ?>"
                   class="input date-picker"
                   name="dt_expire" id="dt_expire">
        </div>
    </div>
    <div class="row text-right">
        <input type="hidden" class="input" title="Id" name="id_report"
               value="<?php echo $report->getId() ?>">
        <button class="button button-orange">Lưu</button>
    </div>
</form>