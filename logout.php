<?php
    session_start();//セッションを使う宣言

    $_SESSION['userId'] = NULL;
    $_SESSION['userName'] = NULL;
    $_SESSION['userPass'] = NULL;
    $_SESSION['login'] = "ログインしていません．";

    header('Location: index.php');
?>
    