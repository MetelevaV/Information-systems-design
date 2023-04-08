<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Остатки товаров</title>
  <link rel="stylesheet" href='style/main.css'/>
</head>
<body>
<form method="POST", action = ""> 
<input required type = "text" placeholder="Введите X" name="X">
<select name="formula"> 
 <option value='1'>√(1/e^x)</option> 
<option value='2'>√(e^(1/x))</option>
<option value='3'>1/√(e^x)</option>
<option value='4'>1/e^√x</option>
<option value='5'>e^(1/√x)</option>
<option value='6'>e^√(1/x)</option>
</select>
<br>
<input type="submit", name='add' value="Посчитать">
</form>
<?php
if(isset($_POST['add'])){ 
    $X = $_POST['X'];
    $formula = $_POST['formula'];
    switch($formula){
        case 1:
            $f1 = sqrt(1/exp($X));
            echo "√(1/e^x) = " . $f1;break;
        case 2:
            if ($X == 0) {
                echo "Некорректное значение";
            }
            else{
            $f2 = sqrt(exp(1/$X));
            echo "√(e^(1/x)) = ". $f2;
            }break;
        case 3:
            $f3 = 1/sqrt(exp($X));
            echo "1/√(e^x) = ". $f3;break;
        case 4:
            if ($X < 0){
                echo "Неккоректное значение";
            }
            else{
            $f4 = 1/exp(sqrt($X));
            echo "1/e^√x = " . $f4;
            }break;
        case 5:
            if ($X <= 0){
                echo "Неккоректное значение";
            }
            else{
            $f5 = exp(1/sqrt($X));
            echo "e^(1/√x) = ". $f5;
            }break;
        case 6:
            if ($X <= 0){
                echo "Неккоректное значение";
            }
            else{            
            $f6 = exp(sqrt(1/$X));
            echo "e^√(1/x) = ". $f6;
            }break;
    }
} ?>
</body>
</html>