<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Подразделение</title>
  <link rel="stylesheet" href='style/main.css'/>
</head>
<body>
<?php
session_start();
include('include/db.php'); ?>
<form method = "POST", action ="">
    <input required type = "text" placeholder="Код подразделения" name="code">
    <input type = "submit"  name="add" value="Добавить">
</form>
<h> </h>
<table border="1">
<thead>
        <tr><th>№</th>
            <th>Код подразделения</th>
            <th>Код внутреннего учета</th>
        </tr>
    </thead>
 <?php
     $result = mysqli_query($connetion,"SELECT * FROM `account` WHERE 1");
     $resultats = mysqli_query($connetion,"SELECT * FROM `account` WHERE 1");
     while (($row = mysqli_fetch_assoc($result))) //функиця mysqli_fetch_assoc возвращает ассоциативный массив, соответствующий выборке
     {
            ?>
             <tr>
             <td><?php echo $row['ID']; ?></td>
            <td><?php echo $row['Код подразделения']; ?></td>
            <td><?php echo $row['Код внутреннего учета']; ?></td>
        </tr>
        <h>  </h>
        <?php
         }
         if(isset($_POST['add'])){
            $CODE = $_POST['code'];
            if ((strlen($CODE) != 7) or (substr($CODE,3,1) != '-')){
                echo '<span style="color:#ff0000;text-align:center;">Вы ввели НЕККОРЕКТНЫЙ код подразделения </span>';
               header("Refresh: 2"); 
            }
            else{
            while (($rown = mysqli_fetch_assoc($resultats)))
            {
                $ID = $rown['ID'] + 1;
            }
            $kod = $CODE . $ID;
            mysqli_query($connetion, "INSERT INTO `account` (`ID`, `Код подразделения`, `Код внутреннего учета`) VALUES (NULL, '$CODE', '$kod');");
            header("Refresh: 0.5"); 
   }
}
?>

 </body>
</html>