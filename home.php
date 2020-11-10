<?php

session_start();

$dsn = 'mysql:dbname=schedule; host=localhost; charset=utf8';
$user = 'root';
$password = 'root';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ホーム画面</title>
</head>

<body>

  <?php

  if (!isset($_SESSION['user'])) {
    // ログイン済みの場合は、マイページへリダイレクト
    header("Location: index.php");
  }

  $sql = "SELECT * FROM users WHERE id=" . $_SESSION['user'] . "";
  $stmt = $dbh->query($sql);


  if (!$stmt) {
    print('クエリーが失敗しました。' . $dbh->error);
    $dbh = null;
    exit();
  }


  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $name = $row['name'];
    $email = $row['email'];
  }

  $sql = "SELECT * FROM schedules";
  $stmt = $dbh->query($sql);

  if (!$stmt) {
    print('クエリーが失敗しました。' . $dbh->error);
    $dbh = null;
    exit();
  }

  ?>

  <form method="post" action="submit.php">
    <h1>ホーム画面</h1>
    <h2>プロフィール</h2><br>
    名前： <?php print $name ?><br>
    メールアドレス： <?php print $email ?>
    </ul>
    <h3>スケジュール一覧</h3>
    <ul>
      <?php

      foreach ($stmt as $row) {
        $begin = $row['begin'];
        $end = $row['end'];
        $place = $row['place'];
        $content = $row['content'];

        print '<input type="radio" name="id" value="' . $row['id'] . '">';
        print 'イベント名：' . $row['sc_name'];
        print ' 開始時間：' . $row['begin'];
        print ' 終了時間：' . $row['end'];
        print ' 場所：' . $row['place'];
        print ' 内容：' . $row['content'];

        print '<br>';
      }
      $stmt = null;

      print '<br>';

      ?>
    </ul><br>


    <input type="submit" name="add" value="追加">

    <input type="submit" name="edit" value="修正">

    <input type="submit" name="delete" value="削除">

    <br><br>

    <a href="logout.php?logout">ログアウト</a>
  </form>


</body>

</html>