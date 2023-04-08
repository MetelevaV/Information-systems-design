<!doctype html>
<html lang="ru"> <!-- указывает естественный язык контента веб страницы -->
<head>
  <meta charset="utf-8" />   <!-- значение атрибута -->
  <title></title>
  <link rel="stylesheet" href='style/staff.css'/>
</head>
<body>
<?php
session_start(); // начало сессии 
include('include/db.php');
?>
<table>
<thead>
<tr><td>№</td>
    <td>ФИО</td>
    <td>Должость</td>
</tr>
</thead>
<form method="POST", action= "out.php"> <!--Форма для кнопки выхода -->
<input type="submit" value="Выход">
</form><br>
<?php
$result = mysqli_query($connetion, "SELECT * FROM `staff` WHERE 1"); //запрос на выбор данных из таблицы staff
while (($row = mysqli_fetch_assoc($result)))
{
?>
 <tr>
 <td><?php echo $row['ID']; ?></td>
<td><?php echo $row['ФИО']; ?></td>
<td><?php echo $row['Должность']; ?></td>
</tr>
<?php
}
?>
<hr>
</body>
</html>