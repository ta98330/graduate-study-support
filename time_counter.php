<?php
session_start();

// OAuthライブラリの読み込み
require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

//認証情報４つ
$consumerKey = "n1lm8fBMMbW5BHuxGF8MbKv5i";
$consumerSecret = "zQtnkslApCg2PsTc9uEvvNI7KsRa79LIJtZZpRuIdcQfc7ngPq";
$accessToken = "3221121236-DSpEQvuGhXtkv8JnCQ3COJAZLkxLcWBqmxytTU4";
$accessTokenSecret = "J9VvLloX8yW7Re32uwPFeAzyr5Ip4OR2aZ40uSAMrkxEy";

//接続
$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);


$pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
$today = date("Y-m-d");

if(!empty($_POST['come']) or (!empty($_POST['out']))){

    $nowtime = date("H:i:s");
    if(!empty($_POST['come'])){
        $st = $pdo->prepare("INSERT INTO user_logs (id, date, start_time) VALUES(?, ?, ?)");
        $st->execute(array($_SESSION['userId'], $today, $nowtime));
        
        
        $st = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = {$_SESSION['userId']}");//現状の更新
        //ツイート
        $res = $connection->post("statuses/update", array("status" => $_SESSION['userName'].'さんが登校しました'));
        
        //echo "登校時間を登録しました．",'<br /><a href="top.php">戻る</a>';
         header('Location: top.php');
    }
    else/*(!empty($_POST['out']))*/{
        $st = $pdo->prepare("UPDATE user_logs SET end_time = ? WHERE id = ? AND date = ?");
        $st->execute(array($nowtime, $_SESSION['userId'], $today));
        
        $st = $pdo->query("UPDATE member SET situation = 'kitaku' WHERE id = {$_SESSION['userId']}");//現状の更新
        
        //ツイート
        $res = $connection->post("statuses/update", array("status" => $_SESSION['userName'].'さんが下校しました'));

        
        //echo "下校時間を登録しました．",'<br /><a href="top.php">戻る</a>';
         header('Location: top.php');
        
        $st = $pdo->query("UPDATE user_logs SET stay_time = TIMEDIFF(end_time,start_time) WHERE id = {$_SESSION['userId']} AND date = '$today'");//滞在時間の計算
        
    }
    
}

if(!empty($_POST['outreset'])){//下校取り消し
    $st = $pdo->query("UPDATE user_logs SET end_time = NULL WHERE id = {$_SESSION['userId']} AND date = '$today'");
    $st = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = {$_SESSION['userId']}");//現状の更新
    
    //ツイート
        $res = $connection->post("statuses/update", array("status" => $_SESSION['userName'].'さんの下校が取り消されました'));
    
    //echo "下校時間を取り消しました．",'<br /><a href="top.php">戻る</a>';
    header('Location: top.php');
}

