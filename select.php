<?php
//1.  DB接続
require_once('config.php');
try {
  $pdo = new PDO('mysql:dbname=' . DB_NAME . ';charset=utf8;host=' . DB_HOST, DB_USER, DB_PASS);
} catch (PDOException $e) {
  exit('DB_CONNECT: ' . $e->getMessage());
}

// ソートの条件を受け取る
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

//２．データ登録SQL作成
$sql = "SELECT id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY id ASC"; // デフォルトのソート順（id順）
// $sql = "SELECT * FROM my_bm_table ORDER BY id ASC";
switch ($sort) {
  case 'py_asc':
    $sql = "SELECT id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY py ASC";
    break;
  case 'py_desc':
    $sql = "SELECT id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY py DESC";
    break;
  case 'status_asc':
    $sql = "SELECT id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY status ASC";
    break;
  case 'status_desc':
    $sql = "SELECT id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY status DESC";
    break;
  case 'action_asc':
    $sql = "SELECT id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY action ASC";
    break;
  case 'action_desc':
    $sql = "SELECT id, isbn, name, author, py, tekiyou, status, action FROM my_bm_table ORDER BY action DESC";
    break;
}

$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); //true or false

//３．データ表示
// $view="";
if ($status == false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR" . $error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONに値を渡す場合に使う
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>登録内容表示</title>
  <link rel="stylesheet" href="style.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/e53e6d346a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    div {
      padding: 10px;
      font-size: 16px;

      td {
        border: 1px solid red;
      }
    }
  </style>
</head>

<body>
  <!-- <body id="main"> -->

  <!-- Head[Start] -->
  <header>
    <nav class="navbar">
      <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand" href="index.php">MY BOOKSHELF</a></div>
      </div>
    </nav>
  </header>
  <!-- Head[End] -->


  <!-- Main[Start] -->
  <div class="container">
    <table>
      <tr>
        <th>#</th>
        <th>ISBN</th>
        <th>書名</th>
        <th>著者</th>

        <th>出版年 <a href="select.php?sort=py_asc"><i class="fas fa-sort-up"></i></a> <a href="select.php?sort=py_desc"><i class="fas fa-sort-down"></i></a></th>
        <!-- <th>出版年 <a href="select.php?sort=py_asc">▲</a> <a href="select.php?sort=py_desc">▼</a></th> -->
        <th>摘要</th>
        <th>ステータス <a href="select.php?sort=status_asc"><i class="fas fa-sort-up"></i></a> <a href="select.php?sort=status_desc"><i class="fas fa-sort-down"></i></a></th>
        <!-- <th>ステータス <a href="select.php?sort=status_asc">▲</a> <a href="select.php?sort=status_desc">▼</a></th> -->
        <th>アクション <a href="select.php?sort=action_asc"><i class="fas fa-sort-up"></i></a> <a href="select.php?sort=action_desc"><i class="fas fa-sort-down"></i></a></th>
        <!-- <th>アクション <a href="select.php?sort=action_asc">▲</a> <a href="select.php?sort=action_desc">▼</a></th> -->
        <th>更新</th>
        <th>削除</th>
      </tr>

      <?php foreach ($values as $value) { ?>
        <tr>
          <td><?= $value["id"] ?></td>
          <td><?= $value["isbn"] ?></td>
          <td><?= $value["name"] ?></td>
          <td><?= $value["author"] ?></td>
          <td><?= $value["py"] ?></td>
          <td><?= $value["tekiyou"] ?></td>
          <td><?= $value["status"] ?></td>
          <td><?= $value["action"] ?></td>
          <td>
            <a href="detail.php?id=<?= $value['id'] ?>" class="btn">更新</a>
          </td>
          <td>
            <form id="deleteForm_<?= $value['id'] ?>" method="POST" action="delete.php">
              <input type="hidden" name="id" value="<?= $value['id'] ?>">
              <button type="button" class="btn btn-danger" onclick="deleteBook(<?= $value['id'] ?>, '<?= $value['name'] ?>')">削除</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
  <!-- Main[End] -->

  <script>
    function deleteBook(id, title) {
      Swal.fire({
        title: '削除確認',
        text: `「${title}」を削除しますか？`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '削除',
        cancelButtonText: 'キャンセル'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById(`deleteForm_${id}`).submit();
        }
      })
    }
  </script>
</body>

</html>