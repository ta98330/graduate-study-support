<?php

require "spheader.php";//ヘッダー読み込み

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

//var_dump($_POST);
/*
$_POST['user'] = 1210960058;
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
    
    $st0 = $pdo->query("SELECT * FROM member WHERE id = {$_POST['user']}");
        while ($row = $st0->fetch()) {
            $name = htmlspecialchars($row['name']);
        }

    //echo "str",$start_time;
    //echo "end",$end_time;
    

    $nowtime = date("H:i:s");
    $twittertime = date("H時i分");

    if(!isset($start_time)){//登校時
        $st1 = $pdo->prepare("INSERT INTO user_logs (id, date, start_time) VALUES(?, ?, ?)");
        $st1->execute(array($_POST['user'], $today, $nowtime));

        //echo "str",$start_time;

        $st2 = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = {$_POST['user']}");//現状の更新
        
        //ツイート
        $res = $connection->post("statuses/update", array("status" => $twittertime.$name.'さんが登校しました. #卒検支援'));
        
        
        
        
        
        
        

    }
    else if(empty($end_time)){//下校時
        $st1 = $pdo->prepare("UPDATE user_logs SET end_time = ? WHERE id = ? AND date = ?");
        $st1->execute(array($nowtime, $_POST['user'], $today));

        //echo "end",$end_time;

        $st2 = $pdo->query("UPDATE member SET situation = 'kitaku' WHERE id = {$_POST['user']}");//現状の更新

        $st3 = $pdo->query("UPDATE user_logs SET stay_time = TIMEDIFF(end_time,start_time) WHERE id = {$_POST['user']} AND date = '$today'");//滞在時間の計算
        
        
        //ツイート
        $res = $connection->post("statuses/update", array("status" => $twittertime.$name.'さんが下校しました. #卒検支援'));

    }
    else{//下校取り消し
        $st1 = $pdo->query("UPDATE user_logs SET end_time = NULL WHERE id = {$_POST['user']} AND date = '$today'");
        $st2 = $pdo->query("UPDATE member SET situation = 'zaishitsu' WHERE id = {$_POST['user']}");//現状の更新
        //echo "stay",$stay_time;
        
        //ツイート
        $res = $connection->post("statuses/update", array("status" => $twittertime.$name.'さんの下校が取り消されました. #卒検支援'));
    }


}







//レスポンス確認
//var_dump($res);