<?php

$dbhost= 'localhost';  
$user= 'root';  
$passwd = 'MysqlPass!2';
$dbname = 'dht';
$conn = new PDO("mysql:dbname=$dbname;host=$dbhost",$user,$passwd);

$conn->exec("set names utf8");
?>