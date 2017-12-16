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
            <img class="display-block image-resize"
                 src="/resources/images/logo.png"
                 alt="Đại học quốc gia thành phố Hồ Chí Minh"/></a>
    </div>
    <h1 class="width-80 text-center text-uppercase text-lg">
        BÁO CÁO SỐ LIỆU CÔNG TÁC SINH VIÊN TRỰC TUYẾN
    </h1>
</div>
<nav class="nav-bar">
    <?php foreach ($menu as $index => $info) {
        ?>
        <div class="nav">
            <a href="<?php echo $info['path'] ?>"
               title="<?php echo $info['name'] ?>">
                <?php echo $info['icon'] ?>
                <span class="nav-text"><?php echo $info['name'] ?></span>
            </a>
        </div>
    <?php } ?>
    <?php if (!empty($user)) { ?>
        <div class="float-right username">
            Xin chào, <?php echo $user->getUsername() ?> |
            <a href="#" title="Đăng xuất" data-action="showFlat">
                <span class="text-white">Thiết lập</span>
            </a> |
            <a href="/index.php?path=thoat"
               title="Đăng xuất">
                <span class="text-white">Thoát</span>
            </a>
        </div>
    <?php } ?>
</nav>
<?php if (!empty($user)) { ?>
    <div id="flat-screen">
        <form method="post" action="/index.php?path=UpdateSetting.post"
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
                                <?php foreach ($user->getSchools() as $school) {
                                    $selected = '';
                                    if ($school->getId() == $activeSchool) {
                                        $selected = 'selected';
                                    }
                                    ?>
                                    <option value="<?php echo $school->getId(
                                    ) ?>" <?php echo $selected ?>>
                                        <?php echo $school->getName() ?>
                                    </option>
                                <?php } ?>
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
<?php } ?>
