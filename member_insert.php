<?php
session_start();
if($_SESSION['userPass'] == $_POST['pass']){
  $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
  $st = $pdo->prepare("UPDATE member SET pass = ? WHERE id = {$_SESSION['userId']}");
  $st->execute(array($_POST['newPass']));
  echo 'パスワードを変更しました。<br /><a href="top.php">戻る</a>';
}
else
   echo 'パスワードが違います．<br /><a href="top.php">戻る</a>'; 
?>
