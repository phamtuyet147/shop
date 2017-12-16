<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/30/2017
 * Time: 6:37 PM
 */
/**
 * @var \apps\ctsv\object\Template[] $templates
 */
?>
<div class="row text-right">
    <a href="/index.php?path=quan-ly/tao-mau-bao-cao" class="button">Tạo mẫu báo
        cáo</a>
</div>
<table class="table">
    <thead>
    <tr>
        <th>STT</th>
        <th>Tên mẫu báo cáo</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($templates as $index => $template) {
        ?>
        <tr>
            <td class="text-center">
                <?php echo $index + 1 ?>
            </td>
            <td>
                <a href="/index.php?path=quan-ly/mau-bao-cao/<?php echo $template->getId(
                ) ?>" class="list-item">
                    <?php echo $template->getName() ?>
                </a>
            </td>
            <td class="text-center">
                <a href="/index.php?path=DeleteTemplate/<?php echo $template->getId(
                ) ?>"
                   class="text-lg" data-action="confirmDelete"
                   title="Xóa mẫu báo cáo"><i
                            class="fa fa-times-circle"></i></a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>