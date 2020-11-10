<?php

session_start();

$dsn = 'mysql:dbname=schedule; host=localhost; charset=utf8';
$user = 'root';
$password = 'root';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = (int)$_SESSION['post_id'];


$sql = "SELECT * FROM schedules WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$sc_name = $row['sc_name'];
$begin = str_replace(" ", "T", $row["begin"]);
$end = str_replace(" ", "T", $row["end"]);
$place = $row["place"];
$content = $row["content"];

if (isset($_POST['edit_done'])) {

    try {
        $sql = "UPDATE schedules SET sc_name=:sc_name, begin=:begin, end=:end, place=:place, content=:content WHERE id=:id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":sc_name", $_POST["sc_name"], PDO::PARAM_STR);
        $stmt->bindValue(":begin", $_POST["begin"], PDO::PARAM_STR);
        $stmt->bindValue(":end", $_POST["end"], PDO::PARAM_STR);
        $stmt->bindValue(":place", $_POST["place"], PDO::PARAM_STR);
        $stmt->bindValue(":content", $_POST["content"], PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $dbh = null;
    } catch (PDOException $e) {
        echo $e;
    }


    header("Location: http://localhost/WebProg/schedule/home.php", true, 301);
    exit();
} else {
    echo <<<EOF

  <!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
</head>
<body>

  
  <h1>スケジュール修正</h1><br />
  <form method="post">
  <br>現在のスケジュール:
  {$sc_name} <br>
  スケジュール名を入力してください<br />
  <input type="text" name="sc_name" style="width: 200px;" value="{$sc_name}" require><br />
  開始時間を入力してください<br />
  <input type="datetime-local" name="begin" style="width: 200px" value="{$begin}" require><br />
  終了時間を入力してください<br />
  <input type="datetime-local" name="end" style="width: 200px" value="{$end}" require><br />
  場所を入力してください<br />
  <input type="text" name="place" style="width: 200px;" value="{$place}" require><br />
  詳細を入力してください<br />
  <input type="text" name="content" style="width: 200px" value="{$content}" ><br />

  <br>
  <input type="button" onclick="history.back()" value="戻る">
  <input type="submit" name="edit_done" value="OK">
  </form>
</body>
</html>
EOF;
}
