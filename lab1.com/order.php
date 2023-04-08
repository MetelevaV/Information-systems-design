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
$result = mysqli_query($connetion,"SELECT * FROM `products` WHERE 1");
$results = mysqli_query($connetion,"SELECT * FROM `products` WHERE 1");?>
 <form method="POST", action= "">
 <input required type="text" placeholder = "ID клиента" name = 'ID'>
 <select name="product_ID"> 
    <?php  while (($row = mysqli_fetch_assoc($result)))
     {
        ?>
<option value='<?php echo $row['Товар']?>'><?php echo $row['Товар']?></option>  
<?php } ?>
</select>
 <td><?php echo $row['ID']; ?></td>
 <input required type="text" placeholder="Количество" name="count">
 <select name="pay_ID"> 
 <option value='nal'>Нал</option> 
<option value='beznal'>Безнал</option> 
<option value='credit'>Кредит</option>
<option value='barter'>Бартер</option>
<option value='netting'>Взаимозачет</option>
</select>
<select name="products_ID"> 
    <?php  while (($rown = mysqli_fetch_assoc($results)))
     {
        ?>
<option value='<?php echo $rown['Товар']?>'><?php echo $rown['Товар']?></option>  
<?php } ?>
</select>
<input type = "submit"  name="create" value="Заказать">
</form>
<form method="POST", action= "out.php"> <!--Форма для кнопки выхода -->
    <input type="submit" value="Выход">
    </form>
<?php

if(isset($_POST['create'])){
    $ID = $_POST['ID'];
    $count = $_POST['count'];//Введенное количество
    $product_ID= $_POST['product_ID'];// выбранный товар
    $products_ID =$_POST['products_ID'];//выбранный товар для бартера
    $pay_ID=$_POST['pay_ID']; //выбранный способ оплаты
    $choose =mysqli_query($connetion, "SELECT * FROM `clientele` WHERE `ID` = '$ID'"); // выборка клиента
    $production = mysqli_query($connetion,"SELECT * FROM `products` WHERE `Товар` = '$product_ID'"); //выборка товара
    $production_barter = mysqli_query($connetion,"SELECT * FROM `products` WHERE `Товар` = '$products_ID'"); //выборка товара для бартера
    $cli = mysqli_fetch_assoc($choose);
    $col = mysqli_fetch_assoc($production);
    $col_barter = mysqli_fetch_assoc($production_barter);
    $score = $cli['Счет']; //счет клиента
    $loan_credit = $cli['Потолок Кредит'];
    $debt = $cli['Долг'];
    $credit_balance =  $cli['Остаток Кредита'];
    $old_sum = $cli['Сумма Покупок']; //сумма покупок клиента
    $kol_barter = $col_barter['Количество'];
    $price_barter = $col_barter['Цена'];
    $kol= $col['Количество'];  //количество товара
    $price = $col['Цена']; // цена товара
    $new_kol = $kol-$count; // новое количество = старое - введенное количество
    $sum = $count * $price; //сумма заказа
    $new_sum = $old_sum + $sum;  // старая сумма + новая
    $new_score = $score - $sum; //новый счет
    $new_debt = $debt + $sum; //новый долг
    $new_credit_balance = $credit_balance - $sum; //новый остаток кредита 
    $netting_kol = $kol+$count;//количество при взаимозачете
    $netting_credit_balance = $credit_balance + $sum; //остаток кредита после взаимозачета
    $netting_debt = $debt - $sum; //долг после взаимозачета
    $con =mysqli_query($connetion, "SELECT * FROM `clientele` WHERE `ID` = '$ID'");
    if ($new_col < 0){
        $new_col = 0;
    }
    if ($count > $kol){ // проверяем не превышает ли количество
        echo '<span style="color:#ff0000;text-align:center;">такого количества нет на складе</span>';
    } elseif(mysqli_num_rows($con) == false){ 
        echo '<span style="color:#ff0000;text-align:center;"> Такого клиента нет </span>';
    }
    else{
    switch($pay_ID){
        case 'nal':
                mysqli_query($connetion, "UPDATE `products` SET `Количество` = '$new_kol' WHERE `products`.`Товар` = '$product_ID'");
                mysqli_query($connetion, "UPDATE `clientele` SET `Сумма Покупок` = '$new_sum' WHERE `clientele`.`ID` = '$ID'");
            break;
        case 'beznal':
            if ($score < ($price * $kol)){ 
            echo '<span style="color:#ff0000;text-align:center;">у вас недостаточно средств</span>';
            }
            else{
                mysqli_query($connetion, "UPDATE `products` SET `Количество` = '$new_kol' WHERE `products`.`Товар` = '$product_ID'");
                mysqli_query($connetion, "UPDATE `clientele` SET `Сумма Покупок` = '$new_sum' WHERE `clientele`.`ID` = '$ID'");
                mysqli_query($connetion, "UPDATE `clientele` SET `Счет` = '$new_score' WHERE `clientele`.`ID` = '$ID'");
    }
        case 'credit':
            if ($credit_balance < (($price * $kol))){
                echo '<span style="color:#ff0000;text-align:center;">у вас недостаточно средств</span>';
            }
            else{
                mysqli_query($connetion, "UPDATE `products` SET `Количество` = '$new_kol' WHERE `products`.`Товар` = '$product_ID'");
                mysqli_query($connetion, "UPDATE `clientele` SET `Сумма Покупок` = '$new_sum' WHERE `clientele`.`ID` = '$ID'");
                mysqli_query($connetion, "UPDATE `clientele` SET `Долг` = '$new_debt' WHERE `clientele`.`ID` = '$ID'");
                mysqli_query($connetion, "UPDATE `clientele` SET `Остаток Кредита` = ' $new_credit_balance' WHERE `clientele`.`ID` = '$ID'");
                if ($new_debt > 0) {
                    mysqli_query($connetion, "UPDATE `clientele` SET `Комментарий` = 'Долг есть' WHERE `clientele`.`ID` = '$ID'");
                }
                else{
                    mysqli_query($connetion, "UPDATE `clientele` SET `Комментарий` = 'Долг отстутствует' WHERE `clientele`.`ID` = '$ID'");
                }
            };break;
        case 'netting':
            mysqli_query($connetion, "UPDATE `products` SET `Количество` = '$netting_kol' WHERE `products`.`Товар` = '$product_ID'");
            mysqli_query($connetion, "UPDATE `clientele` SET `Долг` = '$netting_debt' WHERE `clientele`.`ID` = '$ID'");
            mysqli_query($connetion, "UPDATE `clientele` SET `Остаток Кредита` = '$netting_credit_balance' WHERE `clientele`.`ID` = '$ID'"); 
            if ($new_debt > 0) {
                mysqli_query($connetion, "UPDATE `clientele` SET `Комментарий` = 'Долг есть' WHERE `clientele`.`ID` = '$ID'");
            }
            else{
                mysqli_query($connetion, "UPDATE `clientele` SET `Комментарий` = 'Долг отстутствует' WHERE `clientele`.`ID` = '$ID'");
            };break;
        case 'barter':
            $i = 0;
            while ($sum > $sum_barter){
                $sum_barter = $i * $price_barter;
                $i++;
            }
            $i--;
            if ($i > $kol_barter ){
                echo '<span style="color:#ff0000;text-align:center;">количества товаров нехватает</span>';
            }
            else{
                $new_kol_barter = $kol_barter - $i;
                mysqli_query($connetion, "UPDATE `products` SET `Количество` = '$new_kol_barter' WHERE `products`.`Товар` = '$products_ID'");
                mysqli_query($connetion, "UPDATE `products` SET `Количество` = '$netting_kol' WHERE `products`.`Товар` = '$product_ID'");
            };break;
            }
?>
<br>
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
 $choose_cl =mysqli_query($connetion, "SELECT * FROM `clientele` WHERE `ID` = '$ID'");
 $cl = mysqli_fetch_assoc($choose_cl);
 $FIO = $cl['ФИО'];
 mysqli_query($connetion, "INSERT INTO `orders` (`ID`, `num`, `Клиент`, `Товар`, `Количество`, `Оплата`, `Способ оплаты`) VALUES (NULL, '$ID', '$FIO', '$product_ID', '$count', '$sum', '$pay_ID')");
   $resultat = mysqli_query($connetion,"SELECT * FROM `clientele` WHERE 1");
     while (($rown = mysqli_fetch_assoc($resultat))) //функиця mysqli_fetch_assoc возвращает ассоциативный массив, соответствующий выборке
     {
        if ($rown['ID'] == $ID){
            ?>
             <tr>
             <td><?php echo $rown['ID']; ?></td>
            <td><?php echo $rown['ФИО']; ?></td>
            <td><?php echo $rown['Сумма Покупок']; ?></td>
            <td><?php echo $rown['Счет']; ?></td>
            <td><?php echo $rown['Потолок Кредит']; ?></td>
            <td><?php echo $rown['Долг']; ?></td>
            <td><?php echo $rown['Остаток Кредита']; ?></td>
            <td><?php echo $rown['Комментарий']; ?></td>
        </tr>
        <?php
         }
        }
    }
}
?>
<table border="1">
<thead>
        <tr><td>Товар</td>
            <td>Количество</td>
            <td>Цена</td>
        </tr>
    </thead>
        <?php
        $resul =  mysqli_query($connetion,"SELECT * FROM `products` WHERE 1");
        while (($rown = mysqli_fetch_assoc($resul)))
     {
        ?>
             <tr>
             <td><?php echo $rown['Товар']; ?></td>
            <td><?php echo $rown['Количество']; ?></td>
            <td><?php echo $rown['Цена']; ?></td>
        </tr>
        <?php
        } ?>
        <br>
<h> Склад товаров </h>
<table border="1">
<thead>
        <tr><td>ID</td>
            <td>Номер клиента</td>
            <td>Клиент</td>
            <td>Товар</td>
            <td>Количество</td>
            <td>Сумма</td>
            <td>Способ оплаты</td>
        </tr>
    </thead>
    <h> Заказы </h>
        <?php
        $res =  mysqli_query($connetion,"SELECT * FROM `orders` WHERE 1");
        while (($ron = mysqli_fetch_assoc($res)))
     {
        ?>
             <tr>
             <td><?php echo $ron['ID']; ?></td>
            <td><?php echo $ron['num']; ?></td>
            <td><?php echo $ron['Клиент']; ?></td>
            <td><?php echo $ron['Товар']; ?></td>
            <td><?php echo $ron['Количество']; ?></td>
            <td><?php echo $ron['Оплата']; ?></td>
            <td><?php echo $ron['Способ оплаты']; ?></td>
        </tr>
        <?php
        } ?>
    </body>
</html>