(function($) {
  $(document).ready(function() {
    var keyIndex = $('#countColumns').val();

    var appendColumnHTMLEle = $('#appendColumnHTML');
    appendColumnHTMLEle.removeClass('hide');
    appendColumnHTMLEle.removeAttr('id');
    var appendColumnHTML = appendColumnHTMLEle.clone()[0].outerHTML;
    appendColumnHTMLEle.remove();

    var columns = $('#columns');
    columns.on('click', '.removeColumnBtn', function(event) {
      event.preventDefault();
      $(this).parent().parent().remove();
    });

    $('#addColumnBtn').on('click', function() {
      var html = appendColumnHTML.toString().
          replace(new RegExp(/\[key]/, 'g'), '[' + keyIndex + ']');
      $('#columns').append(html);
      keyIndex++;
    });

    $('#previewBtn').on('click', function(event) {
      event.preventDefault();
      var previewTable = $('#previewTable');
      previewTable.html('');
      var columns = [];
      $('input[name^="columns"]').each(function(index, item) {
        var itemName = item.name;
        var matches = itemName.match(/\[([0-9]+)]\[([a-zA-Z_]+)]/);

        if (matches === null) {
          return;
        }

        if (!columns.hasOwnProperty(matches[1])) {
          columns[matches[1]] = {};
        }
        columns[matches[1]][matches[2]] = item.value;
      });

      var html = '';
      var noRow = 0;
      do {
        var index = 0;
        noRow++;
        var subColumns = [];
        html += '<tr data-row=\'' + noRow + '\'>';
        while (index < columns.length) {
          var column = columns[index];
          html += '<th rowspan=\'' + column.row_span + '\' colspan=\'' +
              column.col_span + '\'>' + column.name + '</th>';
          if (column.col_span > 1) {
            var noSubColumn = 0;
            var colSpan = column.col_span;
            while (noSubColumn < colSpan) {
              index++;
              column = columns[index];
              subColumns.push(column);
              if (column.col_span === '1') {
                noSubColumn++;
              }
            }
          }
          index++;
        }
        columns = subColumns;
        html += '</tr>';
      } while (columns.length > 0);
      previewTable.html(html).parent().removeClass('hide');
    });
  });
})(jQuery);