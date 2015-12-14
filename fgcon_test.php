<?php
//ユーザーデータ
$id = 1210960074;

//POSTデータ
$data = array(
    "user" => "$id",
    "pass" => "pass",
    "come" => "true"
    //"out" => "true"
);
 
// URLを指定
$url = "http://buturi.heteml.jp/student/2015/misawa/test/attendance/pi_attend.php";

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
                      "proxy" => "tcp://proxy02.hiro.kindai.ac.jp:3128", //近大G館プロキシ設定
                      "request_fulluri" => TRUE,
                      'method'=>'POST',
                      'header'=>"Content-Type: application/x-www-form-urlencoded\r\nContent-Length: $data_len",
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



