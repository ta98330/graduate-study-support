


<?php
$url = 'http://buturi.heteml.jp/student/2015/misawa/test/attendance/external_reception.php';
$data = array(
    'name' => 'out',
    
);
$options = array('http' => array(
    'method' => 'POST',
    
));
$contents = file_get_contents($url, false, stream_context_create($options));




if($contents)
    echo "<p>成功</p>";
else 
    echo "<p>失敗しました．</p>";
?>




<?php
function post($url, $data = array()) {
  if (!ini_get('allow_url_fopen')) throw new Exception("Not Allowed URL Open!");
  $stream = stream_context_create(array('http' => array(
    'method' => 'POST',
    'header' => 'Content-type: application/x-www-form-urlencoded',
    'content'   => http_build_query($data),
  )));
  return file_get_contents($url, false, $stream);
}

////// usage sample
try {
  $hoge = post('http://buturi.heteml.jp/student/2015/misawa/test/attendance/external_reception.php', array('name' => 'out'));
  var_dump($hoge);
} catch (Exception $e) {
  var_dump($e);
}