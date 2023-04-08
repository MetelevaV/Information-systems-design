<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />  <!--используемая кодировка -->
  <title>Сотрудники</title>
  <link rel="stylesheet" href='style/staff.css'/> <!--подключение CSS -->
</head>
<body> <!--начало основного кода -->
<header>Список сотрудников фирмы</header>
<?php
session_start();
include('include/db.php'); //подключение таблицы с сервера
$password =$_GET['password'];  //переменная, содержащая данные, введеные в поле пароля при авторизации для дальнейшего взаимодействия с ними
$count = mysqli_query($connetion, "SELECT * FROM `users` WHERE `password` = '$password'"); //сравнение введеных данных с данными, хранящимися в базе данных "users"  

 if (mysqli_num_rows($count) == false){ //если данные не совпадают не с одними из имеющихся
    $_SESSION['message'] = 'Вы не являетесь сотрудником фирмы'; //присваеваем автоматической глобальной переменной текст
    header('Location: index.php'); //используется для отправки http заголовка
}
else {
    switch($password){ //switch() для реализации уровня достпуа 
        case 'ivanov220': //директор
    ?>
        <table> <!--тег для определения таблицы -->
    <thead>
        <tr><td>№</td>
            <td>ФИО</td>
            <td>Должость</td>
            <td>Адрес</td>
            <td>Телефон</td>
        </tr>
    </thead>
    <?php
     $result = mysqli_query($connetion, "SELECT * FROM `staff` WHERE 1"); //переменная, содержащая результаты выполнения SQL запроса
     while (($row = mysqli_fetch_assoc($result))) //функиця mysqli_fetch_assoc возвращает ассоциативный массив, соответствующий выборке
     {
        ?>
         <tr> <!--Вывод таблицы -->
         <td><?php echo $row['ID']; ?></td>
        <td><?php echo $row['ФИО']; ?></td>
        <td><?php echo $row['Должность']; ?></td>
        <td><?php echo $row['Адрес']; ?></td>
        <td><?php echo $row['Телефон']; ?></td>
    </tr>
    <?php
     }
 ?>
     <form method="POST", action= "out.php"> <!--Форма для кнопки выхода -->
    <input type="submit" value="Выход">
    </form><br>
 <form method="POST", action= ""> <!--Форма для добавление новых данных в таблицу staff -->
    <h>Добавить сотрудника: </h>
    <input type="text" placeholder="ФИО" name="FIO">
    <input type="text" placeholder="Должность" name="stat">
    <input type="text" placeholder="Адрес" name="address">
    <input type="text" placeholder="телефон" name="phone">
    <input type="submit" name="add" value="Добавить">
    </form><br>
<form method="POST", action= ""> <!--Форма для удаления сотрудника по ID -->
    <h>Удалить сотрудника: </h>
    <input type="text" placeholder="№" name="ID">
    <input type="submit" name="delet" value="Удалить">
</form><br>
<form method="POST", action= ""> <!--Форма для изменение уже имеющихся данных-->
    <h>Изменить данные сотрудника: </h>
    <input type="text" placeholder="№" name="ID1">
    <input type="text" placeholder="ФИО" name="FIO1">
    <input type="text" placeholder="Должность" name="stat1">
    <input type="text" placeholder="Адрес" name="address1">
    <input type="text" placeholder="телефон" name="phone1">
    <input type="submit" name="change" value="Изменить">
    </form><br>
<?php
if(isset($_POST['add'])){ //если нажата кнопка с именем add, то выполняем добавление данных
    $FIO = $_POST['FIO'];
    $stat = $_POST['stat'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $result = mysqli_query($connetion, "INSERT INTO staff (ID, ФИО, Должность, Адрес, Телефон) values(NULL,'$FIO', '$stat','$address','$phone')"); // SQL запрос добвления данных
    header("Refresh: 0.5"); //обновление страницы с зардержкой в 0.5 секунды для того, чтобы увидеть изменения
}
if(isset($_POST['delet'])){ //если нажата кнопка с именем delet, то удаление выбранной строки
    $ID = $_POST['ID'];
    $result2 = mysqli_query($connetion, "DELETE FROM staff WHERE `staff`.`ID` = '$ID'");
    header("Refresh: 0.5");
}
if(isset($_POST['change'])){ //если нажата кнопка с именем change, то изменяем данных с выбранным номером
    $ID1 = $_POST['ID1'];
    $FIO1 = $_POST['FIO1'];
    $stat1 = $_POST['stat1'];
    $address1 = $_POST['address1'];
    $phone1 = $_POST['phone1'];
    $result3 = mysqli_query($connetion, "UPDATE `staff` SET `ФИО` = '$FIO1', `Должность` = '$stat1', `Адрес` = '$address1', `Телефон` = '$phone1' WHERE `staff`.`ID` = '$ID1'");
    header("Refresh: 0.5");
};
break;
case 'petrov124': //заместитель директора (есть все права, кроме удаления и добавления сотрудников.)
    ?>
        <table>
    <thead>
        <tr><td>№</td>
            <td>ФИО</td>
            <td>Должость</td>
            <td>Адрес</td>
            <td>Телефон</td>
        </tr>
    </thead>
    <?php
     $result = mysqli_query($connetion, "SELECT * FROM `staff` WHERE 1");
     while (($row = mysqli_fetch_assoc($result)))
     {
        ?>
         <tr>
         <td><?php echo $row['ID']; ?></td>
        <td><?php echo $row['ФИО']; ?></td>
        <td><?php echo $row['Должность']; ?></td>
        <td><?php echo $row['Адрес']; ?></td>
        <td><?php echo $row['Телефон']; ?></td>
    </tr>

    <?php
     }
 ?>
 <form method="POST", action= "out.php">
    <input type="sumbit" value="Выход">
</form><br>
<form method="POST", action= "">
    <h>Изменить данные сотрудника: </h>
    <input type="text" placeholder="№" name="ID1">
    <input type="text" placeholder="ФИО" name="FIO1">
    <input type="text" placeholder="Должность" name="stat1">
    <input type="text" placeholder="Адрес" name="address1">
    <input type="text" placeholder="телефон" name="phone1">
    <input type="submit" name="change" value="Изменить">
    </form><br>
<?php
if(isset($_POST['change'])){
    $ID1 = $_POST['ID1'];
    $FIO1 = $_POST['FIO1'];
    $stat1 = $_POST['stat1'];
    $address1 = $_POST['address1'];
    $phone1 = $_POST['phone1'];
    $result3 = mysqli_query($connetion, "UPDATE `staff` SET `ФИО` = '$FIO1', `Должность` = '$stat1', `Адрес` = '$address1', `Телефон` = '$phone1' WHERE `staff`.`ID` = '$ID1'");
    header("Refresh: 0.5");
};
break;
case 'bunny007': //секретарть
    ?>
        <table>
    <thead>
        <tr><td>№</td>
            <td>ФИО</td>
            <td>Должость</td>
            <td>Адрес</td>
            <td>Телефон</td>
        </tr>
    </thead>
    <form method="POST", action= "out.php">
    <input type="submit" value="Выход">
 </form><br>
    <?php
     $result = mysqli_query($connetion, "SELECT * FROM `staff` WHERE 1");
     while (($row = mysqli_fetch_assoc($result)))
     {
        ?>
         <tr>
         <td><?php echo $row['ID']; ?></td>
        <td><?php echo $row['ФИО']; ?></td>
        <td><?php echo $row['Должность']; ?></td>
        <td><?php echo $row['Адрес']; ?></td>
        <td><?php echo $row['Телефон']; ?></td>
    </tr>
    <?php
     };
     break;
     default:
     ?>
     <table>
 <thead>
     <tr><td>№</td>
         <td>ФИО</td>
         <td>Должость</td>
         <td>Адрес</td>
         <td>Телефон</td>
     </tr>
 </thead>
 <form method="POST", action= "out.php">
    <input type="submit" value="Выход">
    </form><br>
 <?php
  $result = mysqli_query($connetion, "SELECT * FROM `staff` WHERE 1");
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

}
}
?> 
<hr>  
</body>
</html>