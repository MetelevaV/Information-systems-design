<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Пробег</title>
  <link rel="stylesheet" href='style/main.css'> <!-- подключение CSS -->
</head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<body>
<?php
session_start();
include('include/db.php');
$result = mysqli_query($connetion,"SELECT * FROM `staff` WHERE 1");
$resultats = mysqli_query($connetion,"SELECT * FROM `avto` WHERE 1");
?>
 <form method="POST", action= "">
 <!-- <input required type="text" placeholder = "Водитель" name = 'staff'> -->
 <select name="staff_ID"> 
    <?php  while (($row = mysqli_fetch_assoc($result)))
     {
        ?>
<option value='<?php echo $row['ФИО']?>'><?php echo $row['ФИО']?></option>  
<?php } ?>
</select>
<select name="drivers_ID"> 
    <?php  while (($rows = mysqli_fetch_assoc($resultats)))
     {
        ?>
<option value='<?php echo $rows['Марка']?>'><?php echo $rows['Марка']?></option>  
<?php } ?>
</select>
<input type="time" placeholder = "Время выезда" name = 'time_out'>
<input type="time" placeholder = "Время заезда" name = 'time_in'>
<input type="text" placeholder = "Начал.километраж" name = 'start_km'>
<input type="text" placeholder = "Конеч.километраж" name = 'finish_km'>
<input type = "submit"  name="check" value="Добавить">
</form>
<?php
if(isset($_POST['check'])){  $staff_ID = $_POST['staff_ID']; $drivers_ID = $_POST['drivers_ID'];
if ($staff_ID == 'Павлов Григорий Владиславович'){
  if(($drivers_ID != 'Mercedes-Benz E220d 4MATIC') && ($drivers_ID != 'BMW X5')){
    echo '<span style="color:#ff0000;text-align:center;">У данного человека нет такой машины </span>';
  }
}
else {
  $resultat = mysqli_query($connetion,"SELECT * FROM `drivers` WHERE `Сотрудник` = '$staff_ID'");
  while (($rown = mysqli_fetch_assoc($resultat)))
     {
      if ($rown['Авто'] != $drivers_ID){
        echo '<span style="color:#ff0000;text-align:center;">У данного человека нет такой машины </span>';
      }
      else{
        $resultati = mysqli_query($connetion,"SELECT * FROM `avto` WHERE `Марка` = '$drivers_ID'");
        $resultati1 = mysqli_query($connetion,"SELECT * FROM `staff` WHERE `ФИО` = '$staff_ID'");
        $mileage = (int)$_POST['finish_km'] - (int)$_POST['start_km'];
        while ($ro = mysqli_fetch_assoc($resultati))
        {
          $standard = $ro['Расход'];
          $old_expense = $ro['Расход топлива'];
        }
        while ($roww = mysqli_fetch_assoc($resultati1))
        {
          $old_mileage = $roww['Пробег'];
        }
        $expense = $mileage * $standard;
        $new_expense = $old_expense + $expense;
        $new_mileage = $old_mileage + $mileage;
        $time_in = $_POST['time_in'];
        $time_out = $_POST['time_out'];
        $start_km = $_POST['start_km'];
        $finish_km = $_POST['finish_km'];
        echo $time_in;
        mysqli_query($connetion, "UPDATE `staff` SET `Пробег` = '$new_mileage' WHERE `staff`.`ФИО` = '$staff_ID'");
        mysqli_query($connetion, "UPDATE `avto` SET `Расход топлива` = '$new_expense' WHERE `avto`.`Марка` = '$drivers_ID'");
        mysqli_query($connetion, "INSERT INTO `waybill` (`ID`, `Водитель`, `Автомобиль`, `Время выезда`, `Время заезда`, `Начальный километраж`, `Конечный километраж`, `Пробег`, `Расход топлива`) VALUES (NULL,'$staff_ID', '$drivers_ID','$time_in','$time_out','$start_km','$finish_km', '$mileage', '$expense')");
      }
    }
  }
}?>
<?php
$res = mysqli_query($connetion,"SELECT * FROM `waybill` WHERE 1");
?> 
<table border="1">
<thead>
        <tr><td>№</td>
            <td>Водитель</td>
            <td>Автомобиль</td>
            <td>Время выезда</td>
            <td>Время заездa</td>
            <td>Начальный километраж</td>
            <td>Конечный километраж</td>
            <td>Пробег</td>
            <td>Расход топлива</td>
        </tr>
    </thead>
 <?php
 $res = mysqli_query($connetion,"SELECT * FROM `waybill` WHERE 1");
     while (($rowq = mysqli_fetch_assoc($res))) //функиця mysqli_fetch_assoc возвращает ассоциативный массив, соответствующий выборке
     {
            ?>
            <br>
             <tr>
             <td><?php echo $rowq['ID']; ?></td>
            <td><?php echo $rowq['Водитель']; ?></td>
            <td><?php echo $rowq['Автомобиль']; ?></td>
            <td><?php echo $rowq['Время выезда']; ?></td>
            <td><?php echo $rowq['Время заезда']; ?></td>
            <td><?php echo $rowq['Начальный километраж']; ?></td>
            <td><?php echo $rowq['Конечный километраж']; ?></td>
            <td><?php echo $rowq['Пробег']; ?></td>
            <td><?php echo $rowq['Расход топлива']; ?></td>
        </tr>
        <?php
         }
         $resulta = mysqli_query($connetion,"SELECT * FROM `avto` WHERE 1");
         while (($r = mysqli_fetch_assoc($resulta))) //функиця mysqli_fetch_assoc возвращает ассоциативный массив, соответствующий выборке
     {    $array[] = $r['Расход топлива'];}
         $resu = mysqli_query($connetion,"SELECT * FROM `staff` WHERE 1");
         while (($ro = mysqli_fetch_assoc($resu)))
         {
          $arr[] = $ro['Пробег'];
         }
         ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ["Audi Q7", <?php echo $array[0];?>, "#CDDC39"],
        ["BMW X5", <?php echo $array[1];?>, "#CDDC39"],
        ["Mazda6", <?php echo $array[2];?>, "#CDDC39"],
        ["Mercedes-Benz E220d 4MATIC", <?php echo $array[3];?>, "#CDDC39"],
        ["RANGE ROVER EVOQUE", <?php echo $array[4];?>, "#CDDC39"],
        ["Toyota Camry", <?php echo $array[5];?>, "#CDDC39"],
        ["Volkswagen Touareg", <?php echo $array[6];?>, "#CDDC39"],
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Расход топлива",
        width: 600,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ["Киселёв", <?php echo $arr[0];?>, "#cc5500"],
        ["Одинцова", <?php echo $arr[1];?>, "#cc5500"],
        ["Павлов", <?php echo $arr[2];?>, "#cc5500"],
        ["Попов", <?php echo $arr[3];?>, "#cc5500"],
        ["Cавельева", <?php echo $arr[4];?>, "#cc5500"],
        ["Стрелков", <?php echo $arr[5];?>, "#cc5500"],
        ["", <?php echo $arr[6];?>, "#cc5500"],
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Пробег",
        width: 600,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_value"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_value" style="width: 900px; height: 300px;"></div>
</body>
</html>