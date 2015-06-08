<?php
$now_year = date("Y"); //現在の年を取得
$now_month = date("n"); //現在の月を取得
$now_day = date("j"); //現在の日を取得
$countdate = date("t"); //今月の日数を取得
$weekday = array("日","月","火","水","木","金","土"); //曜日の配列作成
 
//見出し部分出力
echo "<div>".$now_year.'年'.$now_month."月のカレンダー</div>\n";
 
//一覧表示
for( $day=1; $day <= $countdate; $day++ ){ //今月の日数分ループする
 
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
echo '<div style="'.$style.'">'.$line."</div>\n";
}
?>