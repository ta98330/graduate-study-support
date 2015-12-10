<?php

require "spheader.php";//ヘッダー読み込み

//var_dump($_POST);
/*
$_POST['user'] = 1210960085;
$_POST['pass'] = "pass";
*/

if($_POST['pass'] == "pass"){

    $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
    $today = date("Y-m-d");

    $st = $pdo->query("SELECT * FROM user_logs WHERE id = {$_POST['user']} AND date = '$today'");
        while ($row = $st->fetch()) {
            $start_time = htmlspecialchars($row['start_time']);
            $end_time = htmlspecialchars($row['end_time']);
            $stay_time = htmlspecialchars($row['stay_time']);
        }

    //echo "str",$start_time;
    //echo "end",$end_time;


    $nowtime = date("H:i:s");

    if(!isset($start_time)){//登校時
        $st1 = $pdo->prepare("INSERT INTO user_logs (id, date, start_time) VALUES(?, ?, ?)");
        $st1->execute(array($_POST['user'], $today, $nowtime));

        //echo "str",$start_time;

        $st2 = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = {$_POST['user']}");//現状の更新

    }
    else if(empty($end_time)){//下校時
        $st1 = $pdo->prepare("UPDATE user_logs SET end_time = ? WHERE id = ? AND date = ?");
        $st1->execute(array($nowtime, $_POST['user'], $today));

        //echo "end",$end_time;

        $st2 = $pdo->query("UPDATE member SET situation = 'kitaku' WHERE id = {$_POST['user']}");//現状の更新

        $st3 = $pdo->query("UPDATE user_logs SET stay_time = TIMEDIFF(end_time,start_time) WHERE id = {$_POST['user']} AND date = '$today'");//滞在時間の計算

    }
    else{//下校取り消し
        $st1 = $pdo->query("UPDATE user_logs SET end_time = NULL WHERE id = {$_POST['user']} AND date = '$today'");
        $st2 = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = {$_POST['user']}");//現状の更新
        //echo "stay",$stay_time;
    }


}