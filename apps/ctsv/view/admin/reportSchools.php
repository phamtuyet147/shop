<?php
/**
 * @var \apps\ctsv\object\School[] $schools
 */
?>
<form action="/index.php?path=UpdateSchools.post" method="post">
    <table class="table non-top">
        <thead>
        <tr>
            <th>STT</th>
            <th>Tên trường</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $index = 0;
        foreach ($schools as $index => $school) {
            ?>
            <tr id="row-<?php echo $school->getId() ?>">
                <td>
                    <?php echo $index + 1 ?>
                    <input type="hidden" class="input"
                           name="schools[<?php echo $index ?>][id]"
                           title="Id"
                           value="<?php echo $school->getId() ?>">
                </td>
                <td><input class="input"
                           name="schools[<?php echo $index ?>][name]"
                           title="Tên trường"
                           value="<?php echo $school->getName() ?>">
                </td>
                <td class="text-center">
                    <a href="<?php echo $school->getId() ?>"
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
                       name="schools[<?php echo $index + 1 ?>][id]"
                       title="Id"
                       value=""></td>
            <td><input class="input"
                       name="schools[<?php echo $index + 1 ?>][name]"
                       title="Tên trường"
                       value=""></td>
            <td>

            </td>
        </tr>
        </tbody>
    </table>
    <div class="width-100 text-center">
        <button class="button" name="updateSchools" id="updateSchools"
                title="Cập nhật danh sách trường">Lưu
        </button>
    </div>
</form>