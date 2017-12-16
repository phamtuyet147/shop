WValidate.raiseError = function (formName, fieldName, message) {
  $('.float-alert').remove()
  var html = [
    '<div class="alert alert-danger alert-dismissable fade in float-alert">',
    ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>',
    ' <strong>' + message + '</strong>',
    '</div>'
  ].join('')
  $('body').append(html)
  var fieldDiv = document.forms[formName].elements[fieldName];
  fieldDiv.parentNode.className += ' has-error';
  fieldDiv.focus();
  setTimeout(function () {
    $('.float-alert').remove()
  }, 5000)
}

$(document).ready(function () {
  // noinspection JSPotentiallyInvalidConstructorUsage
  new editormd({
    id: 'editormd',
    path: '/resources/editor/lib/',
    width: '100%',
    height: 500,
    htmlDecode: 'style,script,iframe,sub,sup|on*',
    placeholder: 'Nội dung',
    toolbarAutoFixed: false,
    toolbarIcons: function () {
      return [
        'undo', 'redo', '|', 'bold', 'del', 'italic', 'quote', 'ucwords',
        'uppercase', 'lowercase', '|', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        '|', 'list-ul', 'list-ol', 'hr', '|', 'link', 'image', 'code-block',
        'table', 'html-entities', 'pagebreak', '|', 'goto-line', 'watch',
        'preview', 'fullscreen', 'clear', 'search']
    }
  });

  $('.chosen-select').select2();

  $('#CreateLabel').on('submit', function (event) {
    event.preventDefault();
    var validate = WValidate.validateForm(this.name);
    if (!validate) {
      return false;
    }

    $.ajax({
      url: '/admin/label/add',
      type: 'post',
      dataType: 'json',
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (response) {
        $('#labels').append('<option value="' + response.data['tag'] + '">' +
          response.data['title'] + '</option>')
      },
      error: function () {
        WValidate.raiseError(this.name, 'label', 'Đã xảy ra lỗi!');
      }.bind(this)
    })
  });
})