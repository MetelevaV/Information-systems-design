<script src="chart/lib/liteChart.min.js"></script>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>график</title>
  <link rel="stylesheet" href='style/main.css'/>
</head>
<body>
<form method="POST", action= "">
<input type="text" placeholder="Y" name="Y">
<input type="submit" name="graph" value="Отобразить">
<br>
<br>
<input type="text" placeholder="min" name="min">
<input type="text" placeholder="max" name="max">
<input type="submit" name="new_graph" value="Отобразить">
<br>
<?php 
session_start();
$_SESSION['message1'] = '<span style="color:#ff0000;text-align:center;">Вы ввели слишком много значений</span>';
$_SESSION['message2'] = '<span style="color:#ff0000;text-align:center;">Вы ввели слишком мало значений</span>';
if(isset($_POST['graph'])){ 
    $Y = $_POST['Y'];
$array = explode(' ', $Y);
$array = array_map('intval', $array);
 json_encode($array);
 if (count($array) > 10) {
  if ($_SESSION['message1']){   
    echo '<p class="msg">' . $_SESSION['message1'] . '</p>';
}
unset( $_SESSION['message1']);
 }
 elseif(count($array) < 10){
  if ($_SESSION['message2']){   
    echo '<p class="msg2">' . $_SESSION['message2'] . '</p>';
}
unset( $_SESSION['message2']);
 }
 else{
    echo "Y = ";
    for ($i = 0; $i <count($array); $i++){
        echo $array[$i] . " ";
    }
?>
<script>
    alert($.parseJSON(data));
    </script>
<div id="your-id" style="height: 400px;"></div>
<script>
document.addEventListener("DOMContentLoaded", function(){
	// Create liteChart.js Object
	let d = new liteChart("chart");

	// Set labels
	d.setLabels([1,2,3,4,5,6,7,8,9,10]);

	// Set legends and values
	d.addLegend({"name": "Graph", "stroke": "#CDDC39", "fill": "#fff", "values": [<?php echo $array[0];?>,<?php echo $array[1];?>,<?php echo $array[2];?>,<?php echo $array[3];?>,<?php echo $array[4];?>,<?php echo $array[5];?>,<?php echo $array[6];?>,<?php echo $array[7];?>,<?php echo $array[8];?>,<?php echo $array[9];?>]});

	// Inject chart into DOM object
	let div = document.getElementById("your-id");
	d.inject(div);

	// Draw
	d.draw();
});
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        [1, <?php echo $array[0];?>, "#CDDC39"],
        [2, <?php echo $array[1];?>, "#CDDC39"],
        [3, <?php echo $array[2];?>, "#CDDC39"],
        [4, <?php echo $array[3];?>, "#CDDC39"],
        [5, <?php echo $array[4];?>, "#CDDC39"],
        [6, <?php echo $array[5];?>, "#CDDC39"],
        [7, <?php echo $array[6];?>, "#CDDC39"],
        [8, <?php echo $array[7];?>, "#CDDC39"],
        [9, <?php echo $array[8];?>, "#CDDC39"],
        [10, <?php echo $array[9];?>, "#CDDC39"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Gistoframm",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
<?php } }?> 
<?php 
if(isset($_POST['new_graph'])){
  $Y = $_POST['Y'];
  $MAX = $_POST['max'];
  $MIN = $_POST['min'];
$array = explode(' ', $Y);
$array = array_map('intval', $array);
$count = count($array);
  for ($i = 0; $i < $count; $i++){
    if (($array[$i] < $MIN) or ($array[$i] > $MAX)){
      unset($array[$i]);
    }
}
?>
<script>
    alert($.parseJSON(data));
    </script>
<div id="id" style="height: 400px;"></div>
<script>
document.addEventListener("DOMContentLoaded", function(){
	// Create liteChart.js Object
	let b = new liteChart("chart");

	// Set labels
	b.setLabels([1,2,3,4,5,6,7,8,9,10]);

	// Set legends and values
	b.addLegend({"name": "Graph", "stroke": "#CDDC39", "fill": "#fff", "values": [<?php echo $array[0];?>,<?php echo $array[1];?>,<?php echo $array[2];?>,<?php echo $array[3];?>,<?php echo $array[4];?>,<?php echo $array[5];?>,<?php echo $array[6];?>,<?php echo $array[7];?>,<?php echo $array[8];?>,<?php echo $array[9];?>]});

	// Inject chart into DOM object
	let div = document.getElementById("id");
	b.inject(div);

	// Draw
	b.draw();
});
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        [1, <?php echo $array[0];?>, "#CDDC39"],
        [2, <?php echo $array[1];?>, "#CDDC39"],
        [3, <?php echo $array[2];?>, "#CDDC39"],
        [4, <?php echo $array[3];?>, "#CDDC39"],
        [5, <?php echo $array[4];?>, "#CDDC39"],
        [6, <?php echo $array[5];?>, "#CDDC39"],
        [7, <?php echo $array[6];?>, "#CDDC39"],
        [8, <?php echo $array[7];?>, "#CDDC39"],
        [9, <?php echo $array[8];?>, "#CDDC39"],
        [10, <?php echo $array[9];?>, "#CDDC39"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Gistoframm",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
<?php
}
session_destroy();?> 
 </body>
</html>