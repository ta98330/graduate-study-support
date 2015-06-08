<?php
  $from = "newuser@localhost";
  $to = "newuser@localhost";
  $subject = "メールテスト";
  $body = "メールテストです。\nメールテストです。";
  mb_send_mail($to, $subject, $body, "From: $from");
?>