<?php

session_start();

$dsn = 'mysql:dbname=schedule; host=localhost; charset=utf8';
$user = 'root';
$password = 'root';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_SESSION['post_id'];


$sql = "SELECT * FROM schedules WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$sc_name = $row['sc_name'];
$begin = $row["begin"];
$end = $row["end"];
$place = $row["place"];
$content = $row["content"];

if (isset($_POST['delete_done'])) {

  $id = $_POST['id'];


  $sql = 'DELETE FROM schedules WHERE id=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $id;

  $stmt->execute($data);

  $dbh = null;

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
  
    <h1>スケジュール削除</h1><br />
    <br>スケジュール名：
    {$sc_name}
    <br>開始時間：
    {$begin}
    <br>終了時間：
    {$end}
    <br>場所：
    {$place}
    <br>内容：
    {$content}
  
    <form method="post">
      <input type="hidden" name="id" value="{$id}">
      <br><br>
      <input type="button" onclick="history.back()" value="戻る">
      <input type="submit" name="delete_done" value="OK">
  
    </form>
  </body>
  
  </html>

EOF;
}

?>
