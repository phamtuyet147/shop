<?php
/**
 * @var User                           $user
 * @var array                          $menu
 * @var int                            $curPageId
 * @var \apps\ctsv\object\ReportYear[] $years
 * @var string                         $activeSchool
 * @var string                         $activeYear
 */

use apps\ctsv\object\User;

?>
<div class="top-head width-100">
    <div class="width-20">
        <a class="display-block logo" href="/"
           title="Đại học quốc gia thành phố Hồ Chí Minh">
            <img class="display-block image-resize banner"
                 src="/resources/images/logo_dhqg.png"
                 alt="Đại học quốc gia thành phố Hồ Chí Minh"/></a>
    </div>
    <h1 class="width-80 text-center text-uppercase text-lg">
        BÁO CÁO SỐ LIỆU CÔNG TÁC SINH VIÊN TRỰC TUYẾN
    </h1>
</div>
<nav class="nav-bar">
    {w:action \apps\ctsv\controller\NavGenerator}
</nav>
{w:func if (!empty($user)) {}
<div id="flat-screen">
    <form method="post" name="UpdateSetting"
          action="/index.php?path=UpdateSetting.post"
          class="width-60 width-left-20 vertical-center">
        <fieldset class="fieldset">
            <legend class="legend">Thay đổi thiết lập phiên làm việc
            </legend>
            <div class="row">
                <div class="width-80 width-left-10">
                    <div class="width-30">
                        Chọn trường
                    </div>
                    <div class="width-70">
                        <select name="school" title="Chọn trường"
                                class="input">
                            {w:func foreach ($user->getSchools() as $school) {
                            $selected = '';
                            if ($school->getId() == $activeSchool) {
                            $selected = 'selected'; }
                            {/w:func}
                            <option value="{w:func echo $school->getId()}">
                                <?php echo $school->getName() ?>
                            </option>
                            {/w:func}
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="width-80 width-left-10">
                    <div class="width-30">
                        Chọn năm báo cáo
                    </div>
                    <div class="width-70">
                        <select name="year" title="Chọn năm báo cáo"
                                class="input">
                            <?php foreach ($years as $year) {
                                $selected = '';
                                if ($year->getId() == $activeYear) {
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
            </div>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="legend">Đổi mật khẩu</legend>
            <div class="row">
                <div class="width-80 width-left-10">
                    <div class="width-30">
                        Mật khẩu cũ
                    </div>
                    <div class="width-70">
                        <input type="password" class="input"
                               title="Mật khẩu cũ" name="password_old">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="width-80 width-left-10">
                    <div class="width-30">
                        Mật khẩu mới
                    </div>
                    <div class="width-70">
                        <input type="password" class="input"
                               title="Mật khẩu mới" name="password_new">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="width-80 width-left-10">
                    <div class="width-30">
                        Nhắc lại mật khẩu mới
                    </div>
                    <div class="width-70">
                        <input type="password" class="input"
                               title="Nhắc lại mật khẩu mới"
                               name="password_retype">
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="row text-center">
            <button class="button button-orange">Lưu</button>
            <button class="button button-white" type="button"
                    data-action="hideFlat">Huỷ bỏ
            </button>
        </div>
    </form>
</div>
{/w:func}
