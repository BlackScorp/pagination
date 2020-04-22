<?php
error_reporting(-1);
ini_set('display_errors','On');
$db = new PDO('mysql:host=localhost;dbname=test;charset=utf8','root','');

$statement = $db->prepare("INSERT INTO testdata SET name=:name, content=:content");

for($i = 0;$i<100;$i++){
  $statement->execute([
    'name'=>'Test name '.random_int(0,time()),
    'content'=>'Test content '.random_int(0,time())
  ]);
  echo '.';
}
