<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Заказ</title>
  
  <link rel="stylesheet" href='style/report.css'> <!-- подключение CSS -->
</head>
<body>
<?php
session_start();
include('include/db.php'); 
$result =  mysqli_query($connetion,"SELECT * FROM `remains` WHERE 1");?>
<table>
  <caption>
  Остатки товаров по приходным ценам
  </caption>
<thead>
            <td>Товар</td>
            <td>Цена прихода</td>
            <td>Остаток</td>
            <td>Сумма остатка</td>
        </tr>
    </thead><?php
    $sum = 0;
    $new_sum = 0;
        $resu =  mysqli_query($connetion,"SELECT * FROM `remains` WHERE 1");
        while (($row = mysqli_fetch_assoc($resu))){
            $sum = $sum + $row['Сумма остатка'];
        }
        $res =  mysqli_query($connetion,"SELECT * FROM `remains` WHERE 1");
        while (($ron = mysqli_fetch_assoc($res)))
     {
        ?>
             <tr>
            <td><?php echo $ron['Товар']; ?></td>
            <td><?php echo $ron['Цена прихода']; ?></td>
            <td><?php echo $ron['Остаток']; ?></td>
            <td><?php echo $ron['Сумма остатка']; ?></td>
        </tr>
        <?php
        } ?>
        </thead>
            <tr>  <td><?php echo "Итог:"; ?></td>
          <td><?php echo " "; ?></td>
          <td><?php echo " "; ?></td>
          <td><?php echo  $sum. "Р" ?></td>
        </tr>
        </thead>
<?php 


?>
<form method="POST", action= "">
<select name="product_ID"> 
    <?php
    $result = mysqli_query($connetion,"SELECT * FROM `Products` WHERE 1");
    while (($row = mysqli_fetch_assoc($result)))
     {
        $name = $row['Название'];
        ?>
<option value='<?php echo $name?>'><?php echo $name?></option>  
<?php } ?>
</select>
<input type="submit" name="push" value="Отфильтровать">
</form>
<br>
<?php
$product_ID = $_POST['product_ID'];
if(isset($_POST['push'])){
    $count = mysqli_query($connetion, "SELECT * FROM `remains` WHERE `Товар` = '$product_ID'");
    if (mysqli_num_rows($count) == false){ 
        echo '<span style="color:#ff0000;text-align:center;">такого товара нет</span>';
    }
    else{ ?>
        <table>
        <caption>
        Остатки товаров по приходным ценам
        </caption>
      <thead>
                  <td>Товар</td>
                  <td>Цена прихода</td>
                  <td>Остаток</td>
                  <td>Сумма остатка</td>
              </tr>
              <?php
$r = mysqli_query($connetion, "SELECT * FROM `remains` WHERE `Товар` = '$product_ID'");
while (($row = mysqli_fetch_assoc($r)))
{
   ?>
        <tr>
       <td><?php echo $row['Товар']; ?></td>
       <td><?php echo $row['Цена прихода']; ?></td>
       <td><?php echo $row['Остаток']; ?></td>
       <td><?php echo $row['Сумма остатка']; ?></td>
   </tr>
   <?php
   } ?>
   </thead>

<?php
$calc =  mysqli_query($connetion, "SELECT * FROM `remains` WHERE `Товар` = '$product_ID'");
while (($ro = mysqli_fetch_assoc($calc))){
    $new_sum = $new_sum + $ro['Сумма остатка'];
 } ?>
 <tr>  <td><?php echo "Итог:"; ?></td>
          <td><?php echo " "; ?></td>
          <td><?php echo " "; ?></td>
          <td><?php echo  $new_sum. "Р" ?></td>
        </tr>
        </thead>  <?php

}
 }?>
 <br>
<form method="POST", action= "out.php"> <!--Форма для кнопки выхода -->
    <input type="submit" value="Выход">
    </form>       
    </body>
</html>
