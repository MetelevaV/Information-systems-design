<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Авторизация</title>
  <link rel="stylesheet" href='style/main.css'> <!-- подключение CSS -->
</head>
<body>
<?php
session_start();
include('include/db.php');
?>
<form method="GET" action="/handel.php"> <!-- форма для авторизации и перехода на страницу с данными  -->
      <label>Пароль</label>
      <input type="text" placeholder="Введите пароль" name="password">
      <input type="submit" value="Войти">
</form>
<form method="GET" action="/guest.php"><!-- форма для входа без пароля  -->
      <input type="submit" value="Войти как гость">
      <?php
      if ($_SESSION['message']){   
            echo '<p class="msg">' . $_SESSION['message'] . '</p>';
      }
      unset( $_SESSION['message']); //удаление переменной
      ?>
</form>
</body>
</html>

