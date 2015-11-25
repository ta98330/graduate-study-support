<?php

// 送信先URL
$url = 'https://www.crowdfunder.com/deals';

// パラメータの設定
$param= array(
	// 例えばentities_only=true&page=1のようなパラメータの場合
    'entities_only' => 'true',
    'page' => '1',
);

// methodの設定
$options = array('http' => array(
    'method' => 'POST',
    'content' => http_build_query($param),
));

// file_get_contentsによりリクエストを送信する
$contents = file_get_contents($url, false, stream_context_create($options));

