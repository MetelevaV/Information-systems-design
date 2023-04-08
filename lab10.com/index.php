<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Остатки товаров</title>
  <link rel="stylesheet" href='style/main.css'/>
</head>
<body>
<?php
session_start();
include('include/db.php');
$result= mysqli_query($connetion,"SELECT * FROM `products` WHERE 1");
?>
<form method="POST", action = ""> <!-- форма с всплывающим списком и кнопкой изменения -->
<select name="Date"> 
 <option value='2022-12-11'>2022-12-11</option> 
<option value='2023-01-01'>2023-01-01</option> 
<option value='2023-02-10'>2023-02-10</option>
<option value='2023-03-01'>2023-03-01</option>
<option value='2023-04-10'>2023-04-10</option>
</select>
<br>
<br>
<input type="submit", name='add' value="Вывести"> <!-- кнопка -->
</form>
<br>
<?php
if(isset($_POST['add'])){ 
    $sum = 0;
    $Date = $_POST['Date']?>
    <table>
    <caption>
  Остатки товаров
  </caption>
        <tr><th>Название</th>
            <th>Количество</th>
            <th>Цена</th>
        </tr>
 <?php
     while (($row = mysqli_fetch_assoc($result))) //функиця mysqli_fetch_assoc возвращает ассоциативный массив, соответствующий выборке
     {
        if ($row['Дата'] == $Date){
            $sum += $row['Цена'];
            ?>
             <tr>
             <td><?php echo $row['Название']; ?></td>
            <td><?php echo $row['Количество']; ?></td>
            <td><?php echo $row['Цена']; ?></td>
        </tr>
        <?php
         }
}
?>
         <tr>  <td><?php echo "Итог:"; ?></td>
          <td><?php echo " "; ?></td>
          <td><?php echo $sum ; ?></td>
        </tr>
        <?php
}
?>
</body>
</html>
