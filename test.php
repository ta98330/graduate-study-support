<?php
require "header.php";//ヘッダー読み込み 
//ここから今月の勉強時間表示
//時間の足し算関数
function AddVtime($a,$b){
$aArry=explode(":",$a);
$bArry=explode(":",$b);

return date("H:i:s",mktime($aArry[0]+$bArry[0],$aArry[1]+$bArry[1],$aArry[2]+$bArry[2]));
}

$_SESSION['userId'] = 74;

$thmonth = date("Ym");
$totalstayTime = '00:00:00';
//echo $thmonth;

$pdo = new PDO("mysql:dbname={$_SESSION['dbname']}", "{$_SESSION['dbusername']}", "{$_SESSION['dbpass']}");
$st = $pdo->query("SELECT stay_time FROM user_logs WHERE id = {$_SESSION['userId']} AND DATE_FORMAT(date,'%Y%m') = '$thmonth'");

while ($row = $st->fetch()) {
    $addstayTime = htmlspecialchars($row['stay_time']);
    
    //echo $addstayTime;
    echo "<br />";
    //echo date("H:i:s", $addstyaTime);
    
    

    function strtosec($str) {
    list($h, $m, $s) = explode(':', $str);
    return $h * 3600 + $m * 60 + $s;
    }
    
    echo strtosec($addstayTime);

    function sectostr($val) {
    return sprintf("%02d:%02d:%02d", $val / 3600, ($val % 3600) / 60, $val % 60);
    }
    
    echo sectostr($addstayTime);

    //print sectostr(strtosec($totalstayTime) + strtosec($addstayTime));
    
    
    //$totalstayTime = $totalstayTime + strtotime($addstayTime);
    //echo $totalstayTime; 
    
               
}
    //echo date("H:i:s",$totalstayTime); 




function timetohis( $timesecond )

{

    $hour = floor( $timesecond / 3600 );

    $minute = floor( $timesecond / 60 ) % 60;

    $second = $timesecond % 60;

    return $hour.':'.$minute.':'.$second;

}
//echo "<br />";
//echo timetohis($totalstayTime);