<?php
//POSTデータ
$data = array(
    "user" => "71",
    "pass" => "pass",
    "come" => "true"
);
 
// URLを指定

//ローカル
$url = "http://192.168.11.24/test/attendance/pi_attend.php";

//heteml
//$url = "http://buturi.heteml.jp/student/2015/misawa/test/attendance/pi_attend.php";

//接続テスト
//$url = "http://192.168.11.20/test2.php";

 
// POST用関数
function http_post ($url, $data)
{
  $data_url = http_build_query ($data);
  $data_len = strlen ($data_url);
 
  return array (
        'content'=>  file_get_contents (
            $url,
            false,
            stream_context_create (
              array ('http' =>
                  array (
                      'method'=>'POST',
                      'header'=>"Content-Type: application/x-www-form-urlencoded\r\nContent-Length: $data_len\r\n",
                      'ignore_errors' => true,
                      'content'=>$data_url)
                  )
              )
            ),
      'headers'=> $http_response_header
  );
}
 
// 送信
$result = http_post($url, $data);
?>

受信データ<br />
<pre>
<?php var_dump($result);?>
</pre>


