<?php
// 1. POSTデータ取得
$id = $_POST["id"];
$isbn = $_POST["isbn"];
$name = $_POST["name"];
$author = $_POST["author"];
$py = $_POST["py"];
$tekiyou = $_POST["tekiyou"];
$status = $_POST["status"];
$action = $_POST["action"];

// 2. DB接続
require_once('config.php');
try {
    $pdo = new PDO('mysql:dbname=' . DB_NAME . ';charset=utf8;host=' . DB_HOST, DB_USER, DB_PASS);
} catch (PDOException $e) {
    exit('DB_CONNECT: ' . $e->getMessage());
}

// 3. UPDATE gs_an_table SET ....; で更新
$sql = "UPDATE my_bm_table SET isbn=:isbn, name=:name, author=:author, py=:py, tekiyou=:tekiyou, status=:status, action=:action WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':isbn', $isbn, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':author', $author, PDO::PARAM_STR);
$stmt->bindValue(':py', $py, PDO::PARAM_INT);
$stmt->bindValue(':tekiyou', $tekiyou, PDO::PARAM_STR);
$stmt->bindValue(':status', $status, PDO::PARAM_STR);
$stmt->bindValue(':action', $action, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// 4. データ登録処理後
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:" . $error[2]);
} else {
    echo "<script>alert('更新が完了しました。'); window.location.href='select.php';</script>";
    exit();
}
?>