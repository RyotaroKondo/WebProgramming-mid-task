<?php 
	ob_start();
	session_start();
	if( isset($_SESSION['user']) != "") {
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
	<title>ログインフォーム画面</title>
</head>
<body>
<?php
	if(isset($_GET['delete'])) 
	{ // 会員退会でリダイレクトされたときに実行
		echo '<div role="alert">会員退会が完了しました。</div>';
	}
?>

<?php
	
	if(isset($_POST['login']))
	{

		$email = $_POST['email'];
    	$password = $_POST['password'];

   		//安全対策
    	$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    	$password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

	
		$sql = "SELECT * FROM users WHERE email='$email'";

		$stmt = $dbh->query($sql);

		if (!$stmt) {
			print('ログインに失敗しました。メールアドレスが違う可能性があります。' . $dbh->error);
			$dbh = null;// データベースの切断
			exit();
		}

					
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$db_hashed_pwd = $row['password'];
			$id = $row['id'];
		}

		$dbh = null;

		if(password_verify($password, $db_hashed_pwd))
		{
			$_SESSION['user'] = $id;
			header("Location: home.php");
			exit;
		}
		else 
		{ ?>
			<div role="alert">メールアドレスとパスワードが一致しません。</div>
		  <?php 
		}
	}
	
	



?>
	<form method="post">
		<h1>ログイン画面</h1>
		<dl>
			<dt><label for="q1">メールアドレス</label></dt>
			<dd><input type="email" name="email" size="50" placeholder="○○@○○" required></dd>
			<dt><label for="q2">パスワード</label></dt>
			<dd><input type="password" name="password" size="30" placeholder="○○○○○○○○" required></dd>
		</dl>
		<button type="submit" name="login">ログイン</button>
		<a href="register.php">会員登録はこちら</a>
	</form>
</body>
</html>