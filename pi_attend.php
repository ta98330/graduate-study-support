<?php

require "spheader.php";//ヘッダー読み込み

//var_dump($_POST);

$pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
$today = date("Y-m-d");

if(!empty($_POST['come']) or (!empty($_POST['out']))){

    $nowtime = date("H:i:s");
    
    if(!empty($_POST['come'])){//登校時
        $st = $pdo->prepare("INSERT INTO user_logs (id, date, start_time) VALUES(?, ?, ?)");
        $st->execute(array($_POST['user'], $today, $nowtime));
        
        $st1 = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = {$_POST['user']}");//現状の更新
        
    }
    else{//下校時
        $st = $pdo->prepare("UPDATE user_logs SET end_time = ? WHERE id = ? AND date = ?");
        $st->execute(array($nowtime, $_POST['user'], $today));
        
        $st = $pdo->query("UPDATE member SET situation = 'kitaku' WHERE id = {$_POST['user']}");//現状の更新
        
        $st1 = $pdo->query("UPDATE user_logs SET stay_time = TIMEDIFF(end_time,start_time) WHERE id = {$_POST['user']} AND date = '$today'");//滞在時間の計算
        
    }
    
}
