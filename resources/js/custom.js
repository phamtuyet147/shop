WValidate.raiseError = function (formName, fieldName, message) {
    var fieldDiv = $(document.forms[formName].elements[fieldName]);
    fieldDiv.attr('title', message);
    fieldDiv.tooltip('show');
    fieldDiv.parent().addClass('has-error');
    fieldDiv.focus();
};

$(document).ready(function () {
    CKEDITOR.replaceAll('rich-text-editor');
    CKEDITOR.on('instanceReady', function (event) {
        var editor = event.editor;
        editor.on('change', function () {
            // Sync textarea
            this.updateElement();
        });
    });
});