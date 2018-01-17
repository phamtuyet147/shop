WValidate.raiseError = function (formName, fieldName, message) {
    $('.float-alert').remove();
    var html = [
        '<div class="alert alert-danger alert-dismissable fade in float-alert">',
        ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>',
        ' <strong>' + message + '</strong>',
        '</div>'
    ].join('');
    $('body').append(html);
    var fieldDiv = document.forms[formName].elements[fieldName];
    fieldDiv.parentNode.className += ' has-error';
    fieldDiv.focus();
    setTimeout(function () {
        $('.float-alert').remove()
    }, 5000)
};

$(document).ready(function () {

});