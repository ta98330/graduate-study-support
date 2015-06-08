<?php
    session_start();
    
    //db情報(local)
    $_SESSION['dbname'] = "attendance01";
    $_SESSION['dbusername'] = "root";
    $_SESSION['dbpass'] = "buturi";

    /*db情報(heteml)
    $_SESSION['dbname'] = "_student15;host=mysql137.heteml.jp";
    $_SESSION['dbusername'] = "_student15";
    $_SESSION['dbpass'] = "buturi15";*/

    if(empty($_SESSION['login']))
        $_SESSION['login'] = "ログインしていません．";
    

?>
