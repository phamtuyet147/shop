<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 8/3/2017
 * Time: 7:05 PM
 */
/**
 * @var \apps\ctsv\object\User     $userInfo
 * @var \apps\ctsv\object\School[] $schools
 * @var string                     $userId
 */
$username = $userInfo->getUsername();
?>
<form action="/index.php?path=UpdateAccount.post" method="post"
      class="width-left-10 width-80">
    <div class="row">
        <div class="width-30">
            Tên đăng nhập
        </div>
        <div class="width-70">
            <input title="Tên đăng nhập"
                   class="input" <?php echo (!empty($username)) ? 'disabled'
                : '' ?>
                   name="username" value="<?php echo $username ?>"
                   id="username">
        </div>
    </div>
    <div class="row">
        <div class="width-30">
            Chọn trường
        </div>
        <div class="width-70">
            <?php foreach ($schools as $school) {
                $checked = '';
                $userSchools = $userInfo->getSchools();
                if (!empty($userSchools)) {
                    foreach ($userSchools as $userSchool) {
                        if ($school->getId() == $userSchool->getId()) {
                            $checked = 'checked';
                            break;
                        }
                    }
                }
                ?>
                <div class="row">
                    <label>
                        <input type="checkbox"
                               name="schools[]" <?php echo $checked ?>
                               value="<?php echo $school->getId() ?>">
                        <?php echo $school->getName() ?>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="width-30">
            Mật khẩu
        </div>
        <div class="width-70">
            <input type="password" title="Mật khẩu mới" autocomplete="false"
                   class="input"
                   name="password" id="password">
        </div>
    </div>
    <div class="row text-right">
        <input type="hidden" class="input" title="Id" name="id_user"
               value="<?php echo $userId ?>">
        <button class="button button-orange">Lưu</button>
    </div>
</form>
