<?php
/**
 * @var \apps\ctsv\object\ReportYear[] $years
 * @var \apps\ctsv\object\School[]     $schools
 * @var \apps\ctsv\object\Template[]   $templates
 */
?>
<form action="/index.php?path=CreateReport.post" method="post"
      class="width-left-10 width-80">
    <div class="row">
        <div class="width-30">
            Mẫu báo cáo
        </div>
        <div class="width-70">
            <select name="id_template" class="input" title="Mẫu báo cáo">
                <?php foreach ($templates as $template) { ?>
                    <option value="<?php echo $template->getId() ?>">
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
                   name="name"
                   id="name">
        </div>
    </div>
    <div class="row">
        <div class="width-30">
            Năm báo cáo
        </div>
        <div class="width-70">
            <select name="id_year" class="input" title="Năm báo cáo">
                <?php foreach ($years as $year) { ?>
                    <option value="<?php echo $year->getId() ?>">
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
            <?php foreach ($schools as $school) { ?>
                <div class="row">
                    <label>
                        <input type="checkbox" name="schools[]"
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
                   class="input date-picker"
                   name="dt_expire" id="dt_expire">
        </div>
    </div>
    <div class="row text-right">
        <button class="button button-orange">Lưu</button>
    </div>
</form>