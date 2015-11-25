<?php
try{
$pdo=new PDO('mysql:host=localhost;dbname=testid;charset=utf8','root','buturi',
array(PDO::ATTR_EMULATE_PREPARES => false));
}catch (PDOException $e){
exit('error'.$e->getMessage());
}
$cmd='sudo python /var/www/nfc.py';
exec($cmd,$nym);

echo $nym[0];//学籍番号
echo $nym[1];//時間


$img_dd='./'.$nym[1].'.jpg';
echo $img_dd;
$img=file_get_contents($img_dd);




$stmh=$pdo->prepare("INSERT INTO test(id,img_col,time)VALUES(:id,:img,:time)");

$stmh ->bindValue(':id',$nym[0],PDO::PARAM_STR);
$stmh ->bindParam(':img',$img);
$stmh ->bindParam(':time',$nym[1]);
$stmh ->execute();
$pdo=null;

include
?>