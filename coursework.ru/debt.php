<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Заказ</title>
  
  <link rel="stylesheet" href='style/debt.css'> <!-- подключение CSS -->
</head>
<body>
<?php
session_start();
include('include/db.php'); 
$credit_sum = 0;
$result = mysqli_query($connetion,"SELECT * FROM `debt2` WHERE 1");
while (($ron = mysqli_fetch_assoc($result)))
{ $realz = $ron['Реализация'];
  $beznal = $ron['Безнал'];};
  $resultat = mysqli_query($connetion,"SELECT * FROM `debt` WHERE 1");
  $resultats = mysqli_query($connetion,"SELECT * FROM `debt` WHERE 1");
while (($row = mysqli_fetch_assoc($resultat)))
{ $credit = $row['Кредит'];
  $otsr = $row['Отсрочка'];};
  while (($rown = mysqli_fetch_assoc($resultats) ))
  { $credit_sum = $credit_sum + $rown['Кредит'];};
$credit_sum = abs($credit_sum - $credit);
$sum = $beznal + $credit_sum; ?>
<form method="POST", action= "">
<input type="date" id="date" name="date"/>
<input type="submit" name = "push" value="create">
</form>
<?php $Date = $_POST['date']; 
if(isset($_POST['push'])){
  if($otsr < $Date){
    $credit_sum = abs($credit_sum - $credit);
  }
  ?>
<pre>
<h2>Организация "ООО Кибер Компани"</h2><b>Долги поставщикам на: <?php echo $Date; ?> </b>                                    
К уплате по банку: <?php echo $sum . " руб."; ?>

                    В том числе: текущие платежи за товар: <?php echo $beznal . " руб."; ?>

                    отсроченные платежи: <?php echo $credit_sum . " руб."; ?>

Взято на реализацию товара на : <?php echo $realz . " руб."; ?>

Закуплено с отсрочкой платежа на: <?php echo $credit . " руб."; ?> </pre>



<br>
<br>
<br>
<form method="POST", action= "out.php"> <!--Форма для кнопки выхода -->
    <input type="submit" value="Выход">
    </form>
 <?php } ?>
    </body>
</html>