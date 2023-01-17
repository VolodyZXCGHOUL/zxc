<?php
$field= $_POST['user_login'];
$value = $_POST['user_status'];
$id = $_POST['user_id'];

//подключаемся к бд
$link=mysqli_connect('localhost','root','','kva-kva') or die(mysqli_error($link));

//делаем запрос на обновление строки

$query = "UPDATE users SET ".$field."='".$value."' WHERE id=".$id;


mysqli_query($link,$query);
?>