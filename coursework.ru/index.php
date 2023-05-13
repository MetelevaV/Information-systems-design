<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Заказ</title>
  
  <link rel="stylesheet" href='style/order.css'> <!-- подключение CSS -->
</head>
<body>
<?php
session_start();
include('include/db.php');
$new_sum = 0;
$result = mysqli_query($connetion,"SELECT * FROM `Products` WHERE 1");
$results = mysqli_query($connetion,"SELECT * FROM `Products` WHERE 1");?>
 <form method="POST", action= "">
 <select name="product_ID"> 
    <?php  while (($row = mysqli_fetch_assoc($result)))
     {
        ?>
<option value='<?php echo $row['Название']?>'><?php echo $row['Название']?></option>  
<?php } ?>
</select>
 <input required type="text" placeholder="Количество" name="count">
 <select name="pay_ID"> 
 <option value='Безналичный'>Безналичный</option> 
<option value='Реализация'>Реализация</option> 
<option value='Кредит'>Кредит</option>
</select>
<select name="Otsr">
<option value='Отсутствует'>Отсрочка не нужна</option>  
<option value='1'>1 месяц</option> 
<option value='2'>2 месяца</option> 
<option value='3'>3 месяца</option>
</select>
<input type = "submit"  name="create" value="Заказать">
</form>
<form method="POST", action= "remains.php">
<input type = "submit"  name="report1" value="отчет остатки товаров по приходным ценам">    
</form>
<form method="POST", action= "debt.php">
<input type = "submit"  name="report2" value="отчет «долги с поставщикам» ">
</form>
<?php
if(isset($_POST['create'])){
    $count = $_POST['count'];//Введенное количество
    $product_ID= $_POST['product_ID'];// выбранный товар
    $pay_ID=$_POST['pay_ID']; //выбранный способ оплаты
    $Otsr = $_POST['Otsr'];
    $production = mysqli_query($connetion,"SELECT * FROM `Products` WHERE `Название` = '$product_ID'"); //выборка товара
    $col = mysqli_fetch_assoc($production);
    $kol= $col['Количество'];  //количество товара
    $price = $col['Цена']; // цена товара
    $provider = $col['Поставщик'];
    $country = $col['Страна'];
    $sum = $count * $price; //сумма заказа
    $new_sum = $new_sum + $sum;

    switch($pay_ID){
        case 'Безналичный':
            mysqli_query($connetion, "UPDATE `debt2` SET `Безнал` = '$new_sum' WHERE `debt2`.`ID` = 1");
        break;
        case 'Реализация':
            mysqli_query($connetion, "UPDATE `debt2` SET `Реализация` = '$new_sum' WHERE `debt2`.`ID` = 1");
        break;
        case 'Кредит':
            switch($Otsr){
                case '1': 
                    mysqli_query($connetion, "INSERT INTO `debt` (`ID`, `Кредит`, `Отсрочка`) VALUES (NULL, '$new_sum', '2023-06-13');"); break;
                case '2': 
                    mysqli_query($connetion, "INSERT INTO `debt` (`ID`, `Кредит`, `Отсрочка`) VALUES (NULL, '$new_sum', '2023-07-13');"); break;
                case '3': 
                    mysqli_query($connetion, "INSERT INTO `debt` (`ID`, `Кредит`, `Отсрочка`) VALUES (NULL, '$new_sum', '2023-08-13');"); break;
            }
        break;
            }
$pro = mysqli_query($connetion,"SELECT * FROM `debt` WHERE 1");
 while (($c = mysqli_fetch_assoc($pro)))
     { 
        $OTSR = $c['Отсрочка'];
     }
 mysqli_query($connetion, "INSERT INTO `journal` (`ID`, `Название`, `Количество`, `Цена`, `Поставщик`, `Страна`, `Вид закупки`, `Срок отсрочки`) VALUES (NULL, '$product_ID', '$count', '$price', '$provider','$country', '$pay_ID', '$OTSR');");
 mysqli_query($connetion, "INSERT INTO `remains` (`ID`, `Товар`, `Цена прихода`, `Остаток`, `Сумма остатка`) VALUES (NULL, '$product_ID', '$price', '$count', '$sum');");
        } ?>
    <h> Заказы </h>
    <table border="1">
<thead>
        <tr><td>№</td>
            <td>Название</td>
            <td>Количество</td>
            <td>Цена</td>
            <td>Поставщик</td>
            <td>Страна</td>
            <td>Вид закупкиа</td>
            <td>Срок отсрочки(мес.)</td>
        </tr>
    </thead><?php
        $res =  mysqli_query($connetion,"SELECT * FROM `journal` WHERE 1");
        while (($ron = mysqli_fetch_assoc($res)))
     {
        ?>
             <tr>
             <td><?php echo $ron['ID']; ?></td>
            <td><?php echo $ron['Название']; ?></td>
            <td><?php echo $ron['Количество']; ?></td>
            <td><?php echo $ron['Цена']; ?></td>
            <td><?php echo $ron['Поставщик']; ?></td>
            <td><?php echo $ron['Страна']; ?></td>
            <td><?php echo $ron['Вид закупки']; ?></td>
            <td><?php echo $ron['Срок отсрочки']; ?></td>
        </tr>
        </thead>
        <?php
        } ?>
    </body>
</html>