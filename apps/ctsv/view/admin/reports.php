<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/22/2017
 * Time: 6:39 AM
 */

/**
 * @var \apps\ctsv\object\Report[] $reports
 */
?>
<div class="row text-right">
    <a href="/index.php?path=quan-ly/tao-bao-cao" class="button">Tạo báo cáo</a>
</div>
<table class="table">
    <thead>
    <tr>
        <th>STT</th>
        <th>Tên báo cáo</th>
        <th>Hạn báo cáo</th>
        <th>Ngày báo cáo</th>
        <th>Cập nhật lần cuối</th>
        <th>Thao tác</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($reports as $index => $report) {
        ?>
        <tr>
            <td class="text-center">
                <?php echo $index + 1 ?>
            </td>
            <td>
                <a href="/index.php?path=quan-ly/bao-cao/<?php echo $report->getId(
                ) ?>" class="list-item">
                    <?php echo $report->getName() ?>
                </a>
            </td>
            <td class="text-center">
                <?php echo $report->getExpireDate() ?>
            </td>
            <td class="text-center">
                <?php echo $report->getReportDate() ?>
            </td>
            <td class="text-center">
                <?php echo $report->getLastUpdateDate() ?>
            </td>
            <td class="text-center">
                <a href="/index.php?path=DeleteReport/<?php echo $report->getId(
                ) ?>"
                   class="text-lg" data-action="confirmDelete"
                   title="Xóa báo cáo"><i
                            class="fa fa-times-circle"></i></a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>