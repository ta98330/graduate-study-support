<?php
    require "spheader.php";//ヘッダー読み込み
    
    $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");


    $st = $pdo->prepare("UPDATE member SET situation = ? WHERE id = {$_SESSION['userId']}");//SQL文の発行

    if(!empty($_POST['situation'])){
        $st->execute(array($_POST['situation']));
        //echo '状況を更新しました．<br /><a href="top.php">戻る</a>';
        header('Location: top.php');
    }
    else{
        require "header.php";//ヘッダー読み込み
        echo "<session id='passage'>";
        echo '<p>状況の更新に失敗しました．<br /><a href="top.php">戻る</a></p>';
        echo "<session>";
        require "footer.php"; //フッター読み込み
        
    }
       
    
    /*echo "<form method='post' action='situation_update.php'>";    
                echo "<p>";
                echo "<select name='situation'>";
                echo "<option value='zaisitu'>在室</option>";
                echo "<option value='kitaku'>帰宅</option>";
                echo "<option value='jugyou'>授業</option>";
                echo "<option value='syokuji'>食事</option>";
                echo "<option value='kounai'>校内</option>";
                echo "<option value='kisei'>帰省</option>";
                echo "<option value='syuukatu'>就活</option>";
                echo "</select>";
                echo "<input type='submit' value='状況変更'>";
                echo "</p>";
            echo "</form>";*/
?>