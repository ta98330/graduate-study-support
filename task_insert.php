<?php
    require "spheader.php";//ヘッダー読み込み 
        
    if($_SESSION['login'] == "ログインしていません．"){
        header('Location: index.php');
    }
        
    require "header.php";//ヘッダー読み込み
    
?>
<meta http-equiv="refresh" content="3;URL=top.php">
<section id="passage">
    <?php

    if(!empty($_POST['id'])){
        if(!empty($_POST['content'])){
            $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");

            $st = $pdo->prepare("INSERT INTO task VALUES(?,?,?,?,?)");
            $st->execute(array($_POST['id'], $_POST['date'], $_POST['time'], $_POST['place'], $_POST['content']));
            echo "<p>予定を追加しました．</p>";

            //終了した予定の削除
            $st1 = $pdo->query("DELETE FROM task WHERE date < now() - INTERVAL 1 DAY");

        }
        else{
            echo "<p>予定内容を入力してください．</p>";
        }
    }
    else if(!empty($_POST['content'])){
        $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");

        $st = $pdo->prepare("INSERT INTO task (date, time, place, content) VALUES(?,?,?,?)");
        $st->execute(array($_POST['date'], $_POST['time'], $_POST['place'], $_POST['content']));
        echo "<p>予定を追加しました．</p>";
        
        //終了した予定の削除
        $st1 = $pdo->query("DELETE FROM task WHERE date < now() - INTERVAL 1 DAY");
        
    }
    else{
        echo "<p>予定内容を入力してください．</p>";
    }
    ?>


    <a href="top.php">戻る</a>
    <p>3秒後に自動で戻ります．</p>

</section>
<?php require "footer.php" //フッター読み込み?>