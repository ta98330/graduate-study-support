<?php
session_start();

$pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
$today = date("Y-m-d");

if(!empty($_POST['come']) or (!empty($_POST['out']))){

    $nowtime = date("H:i:s");
    if(!empty($_POST['come'])){
        $st = $pdo->prepare("INSERT INTO user_logs (id, date, start_time) VALUES(?, ?, ?)");
        $st->execute(array($_SESSION['userId'], $today, $nowtime));
        
        $st = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = {$_SESSION['userId']}");//現状の更新      
        
        //echo "登校時間を登録しました．",'<br /><a href="top.php">戻る</a>';
         header('Location: top.php');
    }
    else/*(!empty($_POST['out']))*/{
        $st = $pdo->prepare("UPDATE user_logs SET end_time = ? WHERE id = ? AND date = ?");
        $st->execute(array($nowtime, $_SESSION['userId'], $today));
        
        $st = $pdo->query("UPDATE member SET situation = 'kitaku' WHERE id = {$_SESSION['userId']}");//現状の更新
        
        //echo "下校時間を登録しました．",'<br /><a href="top.php">戻る</a>';
         header('Location: top.php');
        
        $st = $pdo->query("UPDATE user_logs SET stay_time = TIMEDIFF(end_time,start_time) WHERE id = {$_SESSION['userId']} AND date = '$today'");//滞在時間の計算
        
    }
    
}

if(!empty($_POST['outreset'])){//下校取り消し
    $st = $pdo->query("UPDATE user_logs SET end_time = NULL WHERE id = {$_SESSION['userId']} AND date = '$today'");
    $st = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = {$_SESSION['userId']}");//現状の更新
    
    //echo "下校時間を取り消しました．",'<br /><a href="top.php">戻る</a>';
    header('Location: top.php');
}

