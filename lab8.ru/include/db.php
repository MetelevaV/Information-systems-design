<?php
session_start();
$connetion = mysqli_connect('127.0.0.1', 'root','', 'salary'); //функция соединеня с сервером СУБД (в нашем случаи MySQL)

if( $connetion == false )  // В случаи неудачного поключения к серверу ф-я mysqli_connect() возвращает false
{ 
  echo 'Нет подключения <br>';
  echo mysqli_connect_error(); //функция возвращает текстовое описание последней ошибки MySQL.
  exit();
}
?>