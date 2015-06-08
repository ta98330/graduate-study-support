<?php
    require "spheader.php";//ヘッダー読み込み 
        
    if($_SESSION['userId'] != 999){
        //header('Location: index.php');
    }
        
    require "header.php";//ヘッダー読み込み
?>

<section id="passage">
<div id="admin">
<?php
if(!empty($_POST['id'])){
    if(!empty($_POST['period'])){
        
        $start_time = NULL;
        $end_time = NULL;
        $stay_time = NULL;
        
        $pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
        $st = $pdo->query("SELECT * FROM member WHERE id = {$_POST['id']}");
        while ($row = $st->fetch()) {
                $name = htmlspecialchars($row['name']);
            }
        
        list($yy, $mm) = explode('-', $_POST['period']);//文字列の分解
        
        echo "<h2>",$name,"さんの",$yy,"年 ",$mm,"月の出席状況</h2>";

        
        
        //カレンダー
        
        
        
        
        echo '<table border="1"><tr><th>日付</th><th>登校時間</th><th>下校時間</th><th>滞在時間</th></tr>';
        
        $now_year = $yy; //現在の年を取得
        $now_month = $mm; //現在の月を取得
        $now_day = date("j"); //現在の日を取得
        $countdate = date("t"); //今月の日数を取得
        $weekday = array("日","月","火","水","木","金","土"); //曜日の配列作成

        //見出し部分出力
        echo "<div>".$now_year.'年'.$now_month."月</div>\n";

        //一覧表示
        for( $day=1; $day <= $countdate; $day++ ){ //今月の日数分ループする
            
            $st = $pdo->query("SELECT * FROM user_logs WHERE id = {$_POST['id']} AND DATE_FORMAT(date,'%Y-%m-%d') = '{$_POST['period']}-$day'");//SQL文の発行

        while ($row = $st->fetch()) {
                $start_time = htmlspecialchars($row['start_time']);
                $end_time = htmlspecialchars($row['end_time']);
                $stay_time = htmlspecialchars($row['stay_time']);
        }
            
            
            
            
            
            
            

            //各日付の曜日を数値で取得
            //曜日用の配列$weekdayを使い、$weekday[$w]で日本語の曜日が取得できる
            $w = date("w", mktime( 0, 0, 0, $now_month, $day, $now_year ) );

        //スタイルシートの値設定ここから-----------------------------------

        switch( $w ){
            case 0: //日曜日の文字色
                $style = "color:#C30;";
                break;
            case 6: //土曜日の文字色
                $style = "color:#03C;";
                break;
            default: //月～金曜日の文字色
                $style = "color:#333;";
        }

        if( $day == $now_day ){
            $style = $style." background:silver"; //今日の背景色
        }
        //スタイルシートの値設定ここまで-----------------------------------
        
        
        
        
        
        
        
        
        
        $line = $day."日（".$weekday[$w]."）"; //１行の定義：日付（曜日）

        //スタイルシートを挿入・1行ごとに改行して出力
        echo '<tr><td><div style="'.$style.'">'.$line."</div><td>$start_time</td><td>$end_time</td><td>$stay_time</td></td>";
            
        $start_time = NULL;
        $end_time = NULL;
        $stay_time = NULL;
        
        }
        
        echo "</table>";

        echo '<br /><p><a href="top.php">戻る</a></p>'; 
    }
    else
        echo '<p>検索する期間を選択してください．<br />','<a href="top_pro.php">戻る</a></p>';
}
else
    echo '<p>検索する生徒の名前を入力してください．<br />','<a href="top_pro.php">戻る</a></p>'; 

?>
</div>
</section>
<?php require "footer.php" //フッター読み込み?>