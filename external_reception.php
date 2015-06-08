<?php
//session_start();



$pdo = new PDO("mysql:dbname=_student15;host=mysql137.heteml.jp", "_student15", "buturi15");
$today = date("Y-m-d");

if(!empty($_POST['come']) or (!empty($_POST['out']))){

    $nowtime = date("H:i:s");
    if(!empty($_POST['come'])){
        $st = $pdo->prepare("INSERT INTO user_logs (id, date, start_time) VALUES(?, ?, ?)");
        $st->execute(array('74', $today, $nowtime));
        
        $st = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = '74'");//現状の更新      
        
         header('Location: top.php');
    }
    else/*(!empty($_POST['out']))*/{
        $st = $pdo->prepare("UPDATE user_logs SET end_time = ? WHERE id = ? AND date = ?");
        $st->execute(array($nowtime, '74', $today));
        
        $st = $pdo->query("UPDATE member SET situation = 'kitaku' WHERE id = '74'");//現状の更新
        
         header('Location: top.php');
        
        $st = $pdo->query("UPDATE user_logs SET stay_time = TIMEDIFF(end_time,start_time) WHERE id = 74 AND date = '$today'");//滞在時間の計算
        
    }
    
}

else if(!empty($_POST['outreset'])){//下校取り消し
    $st = $pdo->query("UPDATE user_logs SET end_time = NULL WHERE id = '74' AND date = '$today'");
    $st = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = '74'");//現状の更新
    
    header('Location: top.php');
}

else
    echo "<p>失敗しました．</p>";


?>




