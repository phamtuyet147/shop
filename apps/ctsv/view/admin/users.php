<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/26/2017
 * Time: 9:35 PM
 */
/**
 * @var \apps\ctsv\object\User[] $users
 */
?>
<div class="row text-right">
    <a href="/index.php?path=quan-ly/tao-tai-khoan" class="button">Tạo tài
        khoản</a>
</div>
<table class="table">
    <thead>
    <tr>
        <th>STT</th>
        <th>Tên đăng</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($users as $index => $user) {
        ?>
        <tr>
            <td class="text-center">
                <?php echo $index + 1 ?>
            </td>
            <td>
                <a href="/index.php?path=quan-ly/tai-khoan/<?php echo $user->getId(
                ) ?>" class="list-item">
                    <?php echo $user->getUsername() ?>
                </a>
            </td>
            <td class="text-center">
                <a href="/index.php?path=DeleteAccount/<?php echo $user->getId(
                ) ?>"
                   class="text-lg" data-action="confirmDelete"
                   title="Xóa tài khoản"><i
                            class="fa fa-times-circle"></i></a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
