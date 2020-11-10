<?php 

	session_start();
	if( isset($_SESSION['name']) != "") {
	  // ログイン済みの場合は、マイページへリダイレクト
	  header("Location: home.php");
	}
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
	<title>会員登録フォーム画面</title>
</head>
<body>

<?php

if(isset($_POST['signup'])) { // ログインボタンが押下されたときに実行

	$name = $_POST['name'];
	$password = $_POST['password'];
	$email = $_POST['email'];

    //安全対策
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
	$password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
	$password = password_hash($password, PASSWORD_DEFAULT);
	$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');


    $sql = "INSERT INTO users(name, email, password) VALUES('$name','$email', '$password')";
    $stmt = $dbh->prepare($sql);
     
	$stmt->execute();
	
    print $name;
    print 'さんを追加しました。<br />';

	$dbh = null;
	
}

?>

	<form method="post">
		<h1>新規登録</h1>
		<dl>
			<dt><label for="q1">ユーザ名</label></dt>
			<dd><input type="text" name="name" id="q1" size="30" placeholder="○○ ○○" required></dd>
			<dt><label for="q2">メールアドレス</label></dt>
			<dd><input type="email" name="email" id="q2" size="50" placeholder="○○ ○○" required></dd>
			<dt><label for="q3">パスワード</label></dt>
			<dd><input type="password" name="password" id="q3" size="30" placeholder="○○○○○○○○" required></dd>
			

		</dl>
		<button type="submit" name="signup">新規登録</button>
		<a href="index.php">ログインはこちら</a>
	</form>
</body>
</html>
