<?php
	session_start();
	
	// DBとの接続
	$dsn = 'mysql:dbname=schedule; host=localhost; charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if(isset($_GET['delete'])) 
    { // URLクエリパラメータがdeleteだった場合、
	  session_destroy();
	  unset($_SESSION['user']);
	  header("Location: index.php?delete");
    } 
    elseif(isset($_GET['logout'])) 
    { // URLクエリパラメータがlogoutだった場合、
	  session_destroy();
	  unset($_SESSION['user']);
	  header("Location: index.php");
    }
    else 
    {
	  header("Location: index.php");
    }
    
?>
