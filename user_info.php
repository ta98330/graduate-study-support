<?php
    require "spheader.php";//ヘッダー読み込み 
        
    if($_SESSION['login'] == "ログインしていません．"){
        header('Location: index.php');
    }
        
    require "header.php";//ヘッダー読み込み
?>

<section id="passage">

<?php
if(!empty($_POST['pass'])){
    if($_SESSION['userPass'] == $_POST['pass']){
        echo '<h2>ユーザー情報</h2>';
        echo '<table border="1"><br /><tr><th>ID</th><th>名前</th><th>パスワード</th><th>メールアドレス</th></tr><br />';
        $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
        $st = $pdo->query("SELECT * FROM member WHERE id = {$_SESSION['userId']}");//SQL文の発行
                
        while ($row = $st->fetch()) {
            $id = htmlspecialchars($row['id']);
            $name = htmlspecialchars($row['name']);
            $pass = htmlspecialchars($row['pass']);
            $addres = htmlspecialchars($row['address']);
        }
        
        
        
        echo "<tr><td>$id</td><td>$name</td><td>$pass</td><td>$addres</td></tr></table>";
        echo '<br /><p><a href="top.php">戻る</a></p>'; 
    }
    else
        echo '<p>パスワードが違います．<br />','<a href="top.php">戻る</a></p>'; 
}
else
    echo '<p>パスワードを入力してください．<br />','<a href="top.php">戻る</a></p>';

?>

</section>
<?php require "footer.php" //フッター読み込み?>