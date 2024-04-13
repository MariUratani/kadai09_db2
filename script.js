$(document).ready(function() {
    $('#isbn').on('input', function() {
      var isbn = $(this).val();
      if (isbn.length == 13) {
        $.ajax({
          url: 'https://ndlsearch.ndl.go.jp/api/opensearch',
          data: {
            isbn: isbn,
            cnt: 1,
            dpid: 'iss-ndl-opac',
          },
          dataType: 'xml',
          success: function(data) {
            console.log('Ajax success:', data);
            var items = $(data).find('item');
            if (items.length > 0) {
              var title = $(items[0]).find('title').text();
              var author = $(items[0]).find('author').text();
              var issued = $(items[0]).find('dcterms\\:issued').text();
              var year = issued.slice(0, 4);
              $('#name').val(title);
              $('#author').val(author);
              $('#py').val(year);
            } else {
              $('#name').val('');
              $('#author').val('');
              $('#py').val('');
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log('Ajax error:', textStatus, errorThrown);
            $('#name').val('');
            $('#author').val('');
            $('#py').val('');
          }
        });
      }
    });
  });
  
  function confirmSubmit(event) {
    event.preventDefault(); // フォームのデフォルトの送信を防ぐ
    // 入力値を取得
    var isbn = $('#isbn').val();
    var title = $('#name').val();
    var author = $('#author').val();
    var year = $('#py').val();
    var description = $('textarea[name="tekiyou"]').val();
    var status = $('select[name="status"]').val();
    var action = $('select[name="action"]').val();
  
    // ISBNが13桁でない場合はエラーメッセージを表示して処理を中断
    if (!/^\d{13}$/.test(isbn)) {
      Swal.fire({
        title: 'エラー',
        text: 'ISBNは13桁の数字で入力してください。',
        icon: 'error',
        confirmButtonText: 'OK'
      });
      return;
    }
  
    var formattedIsbn = isbn.replace(/(\d{3})(\d{1})(\d{8})(\d{1})/, '$1-$2-$3-$4');
    // 確認メッセージを構築
    var message = 'この内容で登録しますか？<br><br>' +
      'ISBN: ' + formattedIsbn + '<br>' +
      '書名: ' + title + '<br>' +
      '著者: ' + author;
      // '出版年: ' + year + '<br>' +
      // '摘要: ' + description + '<br>' +
      // 'ステータス: ' + status + '<br>' +
      // 'アクション: ' + action;
  
    // 確認ダイアログを表示
    Swal.fire({
      title: '登録確認',
      html: message,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: '登録',
      cancelButtonText: 'キャンセル'
    }).then((result) => {
      if (result.isConfirmed) {
        // 確認ダイアログで「登録」が選択された場合に、フォームを送信
        $('form').submit();
      }
    })
  }