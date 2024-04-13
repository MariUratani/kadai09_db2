<?php
//1. POSTデータ取得
$id = $_POST["id"];

//2. DB接続
require_once('config.php');
try {
    $pdo = new PDO('mysql:dbname=' . DB_NAME . ';charset=utf8;host=' . DB_HOST, DB_USER, DB_PASS);
} catch (PDOException $e) {
    exit('DB_CONNECT: ' . $e->getMessage());
}

//３．データ削除SQL作成
$sql = "DELETE FROM my_bm_table WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //true or false

//４．データ削除処理後
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:" . $error[2]);
} else {
    echo "<script>alert('削除が完了しました。'); window.location.href='select.php';</script>";
    exit();
}
?>