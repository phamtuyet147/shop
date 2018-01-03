(function($) {
  $(document).ready(function() {
    var maxRow = $('table thead').find('tr').length;
    $('table thead tr[data-row="1"]').
        append('<th rowspan="' + maxRow + '">Thao tác</th>');

    var keyIndex = $('#countRows').val();

    var appendRowHTMLEle = $('#appendRowHTML');
    appendRowHTMLEle.removeClass('hide');
    appendRowHTMLEle.removeAttr('id');
    var appendRowHTML = appendRowHTMLEle.clone()[0].outerHTML;
    appendRowHTMLEle.remove();

    var rows = $('#rows');
    rows.on('click', '.removeRowBtn', function(event) {
      event.preventDefault();
      $(this).parent().parent().remove();
    });

    $('#addRowBtn').on('click', function() {
      keyIndex++;
      var html = appendRowHTML.toString().
          replace(new RegExp(/\[key]/, 'g'), '[' + keyIndex + ']');
      $('#rows').append(html);
    });
  });
})(jQuery);