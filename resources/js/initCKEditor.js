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