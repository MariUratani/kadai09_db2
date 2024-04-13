<?php
//1. POSTデータ取得
$isbn = $_POST["isbn"];
$name = $_POST["name"];
$author = $_POST["author"];
$py = $_POST["py"];
$tekiyou = $_POST["tekiyou"];
$status = $_POST["status"];
$action = $_POST["action"];

//2. DB接続
require_once('config.php');
try {
    $pdo = new PDO('mysql:dbname=' . DB_NAME . ';charset=utf8;host=' . DB_HOST, DB_USER, DB_PASS);
} catch (PDOException $e) {
    exit('DB_CONNECT: ' . $e->getMessage());
}

//３．データ登録SQL作成
$sql = "INSERT INTO my_bm_table(isbn,name,author,py,tekiyou, status, action)VALUES(:isbn,:name,:author,:py,:tekiyou,:status,:action);";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':isbn', $isbn, PDO::PARAM_STR);  //MySQLのINT型の最大値は「2147483647」であるため、VARCHAR型を使用する
$stmt->bindValue(':name', $name, PDO::PARAM_STR); 
$stmt->bindValue(':author', $author, PDO::PARAM_STR);
$stmt->bindValue(':py', $py, PDO::PARAM_INT);  
$stmt->bindValue(':tekiyou', $tekiyou, PDO::PARAM_STR); 
$stmt->bindValue(':status', $status, PDO::PARAM_STR);
$stmt->bindValue(':action', $action, PDO::PARAM_STR);
$status = $stmt->execute(); //true or false

//４．データ登録処理後
if ($status == false) {
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:" . $error[2]);
} else {
  //５．index.phpへリダイレクト
  echo "<script>alert('登録が完了しました。'); window.location.href='index.php';</script>";
  exit();
}
?>