<?php

// URLを指定

//ローカル
//$url = "http://192.168.11.24/test/attendance/pi_attend.php";

//heteml
$url = "http://buturi.heteml.jp/student/2015/misawa/test/attendance/pi_attend.php";

//接続テスト
//$url = "http://192.168.11.20/test2.php";


//POSTデータ
$postdata = array(
    "user" => "74",
    "pass" => "pass",
    "come" => "true"
);


$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>

受信データ<br />
<pre>
<?php var_dump($result);?>
</pre>