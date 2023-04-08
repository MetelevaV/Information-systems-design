<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Начисление зарплаты</title>
  <link rel="stylesheet" href='style/main.css'/>
</head>
<body>
<?php
session_start();
include('include/db.php');
$sum = 0;
// $resultats = mysqli_query($connetion,"SELECT * FROM `staff` WHERE 1");
?>
<table>
  <caption>
  Начисление зарплаты
  </caption>
  <tr>
    <th>№</th>
    <th>ФИО</th>
    <th>Выплата, руб.</th>
  </tr>
  <?php
     $result = mysqli_query($connetion,"SELECT * FROM `staff` WHERE 1");
     while (($row = mysqli_fetch_assoc($result))) //функиця mysqli_fetch_assoc возвращает ассоциативный массив, соответствующий выборке
     {
      $sum += $row['Начислено'];
      if ($row['Начислено'] >= 150000.00){            ?>
             <tr>
             <td><?php echo $row['№']; ?></td>
            <td style="color:#009B00"><?php echo $row['ФИО']; ?></td>
            <?php 
            if ($row['Начислено'] % 10 == 0){ ?>
              <td style="color: #8b00ff"><?php echo $row['Начислено']; ?></td>
              <?php }
            else { ?>
              <td><?php echo $row['Начислено']; ?></td>
            <?php } ?>
            </tr>
            <?php
      }
      elseif($row['Начислено'] <= 100000.00){ ?>
        <tr>
        <td><?php echo $row['№']; ?></td>
       <td style="color:#FF0000"><?php echo $row['ФИО']; ?></td>
       <?php 
       if ($row['Начислено'] % 10 == 0){ ?>
        <td style="color: #8b00ff"><?php echo $row['Начислено']; ?></td>
        <?php }
      else { ?>
        <td><?php echo $row['Начислено']; ?></td>
      <?php } ?>
       </tr>
       <?php
      }
      elseif(($row['Начислено'] > 100000.00) and ($row['Начислено'] < 150000.00)){ ?>
        <tr>
        <td><?php echo $row['№']; ?></td>
       <td style="color: #FBEC5D"><?php echo $row['ФИО']; ?></td>
       <?php 
       if ($row['Начислено'] % 10 == 0){ ?>
        <td style="color: #8b00ff"><?php echo $row['Начислено']; ?></td>
        <?php }
      else { ?>
        <td><?php echo $row['Начислено']; ?></td>
<?php } ?>
       </tr>
       <?php
      }
         }
?>  <tr>  <td><?php echo "Итог:"; ?></td>
          <td><?php echo " "; ?></td>
          <td><?php echo $sum . ".00"; ?></td>
        </tr>
</table>
<a class = "bot1" href="#" onclick="window.print()">Распечатать</a>
 </body>
</html>