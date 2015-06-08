<?php
    session_start();
    $_SESSION['dbhostname'] = "mysql137.heteml.jp";
    $_SESSION['dbname'] = "_student15";
    $_SESSION['dbusername'] = "_student15";
    $_SESSION['dbpass'] = "buturi15";
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
        <link rel="stylesheet" href="base.css">
        
		<title>出席管理</title>
    </head>
    <body>
    <?php  

    // MySQL に接続し、データベースを選択します。  
$conn = mysql_connect($_SESSION['dbhostname'], $_SESSION['dbusername'], $_SESSION['dbpass']) or die(mysql_error());  
    mysql_select_db($_SESSION['dbname']) or die(mysql_error());  

    // SQL クエリを実行します。  
    $res = mysql_query('SELECT * from member') or die(mysql_error());  

    // 結果を出力します。  
    while ($row = mysql_fetch_array($res, MYSQL_NUM)) {  
        echo $row[0] . "\n";  
    }  

    // 結果セットを開放し、接続を閉じます。  
    mysql_free_result($res);  
    mysql_close($conn);  

    ?>  
    </body>
</html>