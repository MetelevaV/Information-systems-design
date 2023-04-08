<?php
session_start(); //начало сессии
session_destroy(); //уничтожение сессии
header('Location: index.php');  //перенаправление
?>