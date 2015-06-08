<?php
    require "spheader.php";//ヘッダー読み込み

    if($_SESSION['login'] != "ログインしていません．"){
        header('Location:top.php');
    }

    require "header.php";//ヘッダー読み込み 
    
    require "state.php";//ヘッダー読み込み
?>

    <section id="passage">
        <h2>ログイン</h2>
        
        <form class="form" name="iform" action="login.php" method="post">
          ID<br><input type="number" name="id" required><br>
          パスワード<br><input type="password" name="pass" required><br> 
          <input type="submit" value="ログイン">
        </form>
            
            
    </section>



    
    
<?php require "footer.php" //フッター読み込み?>