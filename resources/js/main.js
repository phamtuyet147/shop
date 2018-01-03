/**
 * Created by SH on 7/27/2017.
 */
(function ($) {
    $(document).ready(function () {
        $('[data-action="showFlat"]').on('click', function (event) {
            event.preventDefault();
            $('#flat-screen').show().animate({top: '0'}, 'fast');
        });

        $('[data-action="hideFlat"]').on('click', function (event) {
            event.preventDefault();
            $('#flat-screen').animate({top: '-1000px'}, 'fast', function () {
                $(this).hide();
            });
        });

        $('form').on('submit', function () {
            var flagError = false;
            $(this).find('.required').each(function (index, item) {
                if ($(item).val() === '') {
                    $(item).addClass('error');
                    flagError = true;
                }
            });

            if (flagError) {
                $($(this).find('.required')[0]).trigger('focus');
                $('.container').prepend(
                    '<div class="message message-error text-center">Vui lòng nhập đầy đủ thông tin yêu cầu</div>');
                return false;
            }

            return true;
        });

        $('#rows').on('keydown', 'input[data-constraint="numeric"]', function (event) {
            var keyCode = (event.keyCode ? event.keyCode : event.which);
            var allowedKey = [8, 9, 13, 37, 39, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 110, 190];
            if ($.inArray(keyCode, allowedKey) === -1) {
                event.preventDefault();
            }
        });

        $('.removeRowBtn').on('click', function (event) {
            event.preventDefault();
            $(this).parent().parent().remove();
        });

        $('[data-action="confirmDelete"]').on('click', function () {
            var confirm = confirm(
                'Bạn đang muốn xoá dữ liệu, bạn có chắc mình muốn thực hiện thao tác này không? Lưu ý: Dữ liệu sau khi bị xoá sẽ không thể phục hồi lại được!');
            return !confirm;
        });
    });
})(jQuery);