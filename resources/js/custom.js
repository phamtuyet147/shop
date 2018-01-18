WValidate.raiseError = function (formName, fieldName, message) {
    var fieldDiv = $(document.forms[formName].elements[fieldName]);
    fieldDiv.attr('title', message);
    fieldDiv.tooltip('show');
    fieldDiv.parent().addClass('has-error');
    fieldDiv.focus();
};

$(document).ready(function () {
    $('.btn-add-to-cart').on('click', function (event) {
        event.preventDefault();
        var id = $(this).attr('href');
        $.post('/add-to-cart', {id: id}, function (response) {
            if (response.hasOwnProperty('error') && response.error) {
                alert('Error occurred!');
                return false;
            }
            $('#in-cart').html(response.data);
        }, 'json')
    })
});