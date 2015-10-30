<?php
    require "spheader.php";//ヘッダー読み込み

    if($_SESSION['login'] != "ログインしていません．"){
        header('Location:top.php');
    }

    require "header.php";//ヘッダー読み込み 
    
    require "state.php";//ヘッダー読み込み
?>

    <section id="loginform">
        <h2><i class="fa fa-sign-in"></i>ログイン</h2>
        <form class="form" name="iform" action="login.php" method="post">
            <label>ID:</label>
            <input type="number" name="id" required><br />
            <label>パスワード:</label>
            <input type="password" name="pass" required><br />
            <input type="submit" value="ログイン">
        </form>
            
            
    </section>



    
    
<?php require "footer.php" //フッター読み込み?>