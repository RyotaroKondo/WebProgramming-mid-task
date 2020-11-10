<?php

$dsn = 'mysql:dbname=schedule; host=localhost; charset=utf8';
$user = 'root';
$password = 'root';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>


<?php

	
	if(isset($_POST['add_done']))
	{
       
		$sc_name = $_POST['sc_name'];
        $begin = $_POST['begin'];
        $end = $_POST['end'];
        $place = $_POST['place'];
        $content = $_POST['content'];

   		//安全対策
    	$sc_name = htmlspecialchars($sc_name, ENT_QUOTES, 'UTF-8');
        $begin = htmlspecialchars($begin, ENT_QUOTES, 'UTF-8');
        $end = htmlspecialchars($end, ENT_QUOTES, 'UTF-8');
        $place = htmlspecialchars($place, ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

	
		$sql = "INSERT INTO schedules(sc_name, begin, end, place, content) VALUES('$sc_name','$begin','$end','$place','$content')";

        //$stmt = $dbh->query($sql);
        $stmt = $dbh->prepare($sql);
        
        $stmt->execute();

    

        print '<br>';
        print 'イベント名：'.$sc_name.'<br>';
        print '開始時間：'.$begin.'<br>';
        print '終了時間：'.$end.'<br>';
        print '場所：'.$place.'<br>';
        print '詳細：'.$content.'<br>';
        print 'を追加しました。<br />';

        print '<a href="home.php">ホームに戻る</a>';

		$dbh = null;

	}else{
    echo <<<EOF
    

    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8">
    <title></title>
    </head>
    <body>


    <h1>スケジュール追加</h1><br />
    <form method="post">
    スケジュール名を入力してください<br />
    <input type="text" name="sc_name" style="width: 200px;" require><br />
    開始時間を入力してください<br />
    <input type="datetime-local" name="begin" style="width: 200px" require><br />
    終了時間を入力してください<br />
    <input type="datetime-local" name="end" style="width: 200px" require><br />
    場所を入力してください<br />
    <input type="text" name="place" style="width: 200px;" require><br />
    詳細を入力してください<br />
    <input type="text" name="content" style="width: 200px" ><br />

    <br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" name="add_done" value="OK">
    </form>
    </body>
    </html>
EOF;
}
