<?php
session_start();
$today = date("Y-m-d H:i:s");
$pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");


if(!empty($_POST['contributeContent'])){
    $st = $pdo->prepare("INSERT INTO bbs_logs VALUES(?, '$today', ?)");//SQL文の発行
    $st->execute(array($_POST['contributeName'], $_POST['contributeContent']));
}

if(!empty($_POST['alldel'])){
    $st = $pdo->query("DELETE FROM bbs_logs");//SQL文の発行
    
}


header('Location: top.php#bbsend');
?>