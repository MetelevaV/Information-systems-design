<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Клиент</title>
  <link rel="stylesheet" href='style/main.css'/>
</head>
<body>
<?php
session_start();
include('include/db.php');
$resultats = mysqli_query($connetion,"SELECT * FROM `products` WHERE 1");
?>
<form method = "POST", action ="">
    <input type = "text" placeholder="Имя клиента" name="client">
    <input type = "submit"  name="push" value="Поиск">
</form>
<form method = "POST", action ="order.php">
<input type = "submit"  name="make" value="Сделать заказ">
</form>
<?php
if(isset($_POST['push'])){
$client = $_POST['client'];
$count =mysqli_query($connetion, "SELECT * FROM `clientele` WHERE `ФИО` = '$client'");
if (mysqli_num_rows($count) == false){ 
    echo '<span style="color:#ff0000;text-align:center;">такого клиента нет</span>';
}
else{
?>
<table border="1">
<thead>
        <tr><td>№</td>
            <td>ФИО</td>
            <td>Сумма покупок</td>
            <td>Счёт</td>
            <td>Потолок Кредита</td>
            <td>Долг</td>
            <td>Остаток Кредита</td>
            <td>Комментарий</td>
        </tr>
    </thead>
 <?php
     $result = mysqli_query($connetion,"SELECT * FROM `clientele` WHERE 1");
     while (($row = mysqli_fetch_assoc($result))) //функиця mysqli_fetch_assoc возвращает ассоциативный массив, соответствующий выборке
     {
        if ($row['ФИО'] == $client){
            ?>
             <tr>
             <td><?php echo $row['ID']; ?></td>
            <td><?php echo $row['ФИО']; ?></td>
            <td><?php echo $row['Сумма Покупок']; ?></td>
            <td><?php echo $row['Счет']; ?></td>
            <td><?php echo $row['Потолок Кредит']; ?></td>
            <td><?php echo $row['Долг']; ?></td>
            <td><?php echo $row['Остаток Кредита']; ?></td>
            <td><?php echo $row['Комментарий']; ?></td>
        </tr>
        <h> </h>
        <?php
         }
        }
        }
    } 
?>
<table class="table" border = 1>
<thead>
        <tr><td>Товар</td>
            <td>Количество</td>
            <td>Цена</td>
        </tr>
    </thead>
   <?php
    while (($rows = mysqli_fetch_assoc($resultats))) //функиця mysqli_fetch_assoc возвращает ассоциативный массив, соответствующий выборке
    {
           ?>
            <tr>
            <td><?php echo $rows['Товар']; ?></td>
           <td><?php echo $rows['Количество']; ?></td>
           <td><?php echo $rows['Цена']; ?></td>
       </tr>
       <?php
        }
 ?>
 </body>
</html>