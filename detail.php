<?php
// 1. GETデータ取得
$id = $_GET["id"];

// 2. DB接続
require_once('config.php');
try {
    $pdo = new PDO('mysql:dbname=' . DB_NAME . ';charset=utf8;host=' . DB_HOST, DB_USER, DB_PASS);
} catch (PDOException $e) {
    exit('DB_CONNECT: ' . $e->getMessage());
}

// 3. SELECT * FROM xxx WHERE id=:id
$sql = "SELECT * FROM my_bm_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// 4. データ表示
$view = "";
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL_ERROR" . $error[2]);
} else {
    $row = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>詳細・更新</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
            </div>
        </nav>
    </header>

    <form method="POST" action="update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>詳細・更新</legend>
                <label>ISBN：<input type="text" name="isbn" value="<?= $row["isbn"] ?>"></label><br>
                <label>書名：<input type="text" name="name" value="<?= $row["name"] ?>"></label><br>
                <label>著者：<input type="text" name="author" value="<?= $row["author"] ?>"></label><br>
                <label>出版年：<input type="text" name="py" value="<?= $row["py"] ?>"></label><br>
                <label><textArea name="tekiyou" rows="2" cols="32"><?= $row["tekiyou"] ?></textArea></label><br>
                <label>ステータス：
                    <select name="status">
                        <option value="" <?php if ($row['status'] == '') echo 'selected'; ?>></option>
                        <option value="未読" <?php if ($row['status'] == '未読') echo 'selected'; ?>>未読</option>
                        <option value="読了" <?php if ($row['status'] == '読了') echo 'selected'; ?>>読了</option>
                        <option value="読みかけ" <?php if ($row['status'] == '読みかけ') echo 'selected'; ?>>読みかけ</option>
                    </select>
                </label><br>
                <label>アクション：
                    <select name="action">
                        <option value="" <?php if ($row['action'] == '') echo 'selected'; ?>></option>
                        <option value="お気に入り" <?php if ($row['action'] == 'お気に入り') echo 'selected'; ?>>お気に入り</option>
                        <option value="売却予定" <?php if ($row['action'] == '売却予定') echo 'selected'; ?>>売却予定</option>
                        <option value="保留" <?php if ($row['action'] == '保留') echo 'selected'; ?>>保留</option>
                    </select>
                </label><br>
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="submit" value="更新">
            </fieldset>
        </div>
    </form>
</body>

</html>