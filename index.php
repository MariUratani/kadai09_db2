<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
    div {
      padding: 10px;
      font-size: 16px;
    }

    input[type="text"],
    select {
      height: 30px;
      padding: 5px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .btn-primary {
      background-color: #3085d6;
      border-color: #3085d6;
    }

    .btn-primary:hover {
      background-color: #2b79c5;
      border-color: #2b79c5;
    }
  </style>
</head>

<body>

  <!-- Head[Start] -->
  <header>
    <nav class="navbar">
      <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand" href="select.php">Add to BOOKSHELF</a></div>
      </div>
    </nav>
  </header>
  <!-- Head[End] -->

  <!-- Main[Start] -->
  <form method="POST" action="insert.php">
    <div class="container">
      <fieldset>
        <!-- <legend>BOOKSHELF</legend> -->
        <div>
          <div id="bookInfo">
            <div>
              <label for="isbn">ISBN:</label>
              <label><input type="text" name="isbn" id="isbn" required pattern="\d{13}"></label><br>
              <!-- <label>ISBN：<input type="text" name="isbn" id="isbn" required pattern="\d{13}"></label><br> -->
            </div>
            <div>
              <label for="name">書名:</label>
              <input type="text" name="name" id="name" readonly>
            </div>
            <!-- <label>書名：<input type="text" name="name" id="name" readonly></label><br> -->
            <div>
              <label for="author">著者:</label>
              <input type="text" name="author" id="author" readonly>
            </div>
            <!-- <label>著者：<input type="text" name="author" id="author" readonly></label><br> -->
            <div>
              <label for="py">出版年:</label>
              <input type="text" name="py" id="py" readonly>
            </div>
            <!-- <label>出版年：<input type="text" name="py" id="py" readonly></label><br> -->
            <div>
              <label for="tekiyou">摘要:</label>
              <textarea name="tekiyou" rows="2" cols="32"></textarea>
            </div>
            <!-- <label><textArea name="tekiyou" rows="2" cols="32"></textArea></label><br> -->
            <div>
              <label for="status">ステータス:</label>
              <select name="status">
                <option value=""></option>
                <option value="未読">未読</option>
                <option value="読了">読了</option>
                <option value="読みかけ">読みかけ</option>
              </select>
            </div>
            <div>
              <label for="action">アクション:</label>
              <select name="action">
                <option value=""></option>
                <option value="お気に入り">お気に入り</option>
                <option value="売却予定">売却予定</option>
                <option value="保留">保留</option>
              </select>
            </div>
            <!-- 登録ボタンのonclickイベント -->
            <input type="submit" value="登録" class="btn btn-primary">
            <!-- <input type="submit" value="登録" class="btn btn-danger" onclick="confirmSubmit(event)"> -->
            <!-- <input type="submit" value="登録" class="btn btn-primary"> -->
      </fieldset>
    </div>
  </form>
  <!-- Main[End] -->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="script.js"></script>

</body>

</html>