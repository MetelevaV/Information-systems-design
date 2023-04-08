<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <title>Таблица</title>
  <link rel="stylesheet" href='style/main.css'/>
  <style type="text/css">
 .column { height:400px; width:18px; }
 .column div { border:1px solid black; background:#090; width:16px; margin:-1px 0; }
 .chart { background:url(image/chart.png) no-repeat; padding:4px; }
 .height40 { height:40px; }
</style>
</head>
<body>
<?php
include 'simple_html_dom.php';
require 'php-export-data.class.php';
require_once("phpChart_Lite\conf.php");
session_start();
?>
<form method = "POST", action ="">
    <input type = "submit"  name="push" value="Выполнить">
</form>
<?php 
$usd = $eur = 0;
$xml = simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date('d/m/Y'));
$arr = array(); 
foreach ($xml AS $el){ 
  $arr[strval($el->CharCode)] = strval($el->Value);
}
$USD1 = (float)$arr['USD']; 
$EUR1 = (float) $arr['EUR']; 
//echo "USD = " .$USD . "; EUR = " . $EUR;

$html1 = file_get_html('https://ru.investing.com/indices/us-spx-500');
if(count($html1->find('span.text-2xl'))){
  foreach($html1->find('span.text-2xl') as $span)
  $SR = (float)$span->innertext;
}
$html2 = file_get_html('https://mainfin.ru/currency/moskva');
if(count($html2->find('#otkritie_buy_usd'))){
  foreach($html2->find('#otkritie_buy_usd') as $otr_usd)
  $USD2 = (float)$otr_usd->innertext;
}
if(count($html2->find('#otkritie_buy_eur'))){
  foreach($html2->find('#otkritie_buy_eur') as $otr_eur)
  $EUR2 =(float)$otr_eur->innertext;
}
if(count($html2->find('#sberbank_buy_usd'))){
  foreach($html2->find('#sberbank_buy_usd') as $sber_usd)
  $USD3 = (float)$sber_usd->innertext;
}
if(count($html2->find('#sberbank_buy_eur'))){
  foreach($html2->find('#sberbank_buy_eur') as $sber_eur)
  $EUR3 = (float)$sber_eur->innertext;
}
$SR_USD = ($USD1 + $USD2 + $USD3)/3;
$SR_EUR = ($EUR1 + $EUR2 + $EUR3)/3;
$pc=new C_PhpChartX(array(array($SR_USD, $SR_EUR, $SR)), 'simplest_graph');
$pc->draw();
$exporter = new ExportDataExcel('file', 'test.xls');
$exporter->initialize(); 
$exporter->addRow(array("USD", "EUR", "SP", "Date", "Birga")); 
$exporter->addRow(array("$USD1", "$EUR1", "$SR",date("d.m.Y"),"CB RF"));
$exporter->addRow(array("$USD2", "$EUR2", "$SR",date("d.m.Y"),"Otkritie"));
$exporter->addRow(array("$USD3", "$EUR3", "$SR",date("d.m.Y"),"SBER"));
$exporter->addRow(array("$SR_USD", "$SR_EUR", "$SR"));


$exporter->finalize(); // writes the footer, flushes remaining data to browser.

exit(); // all done


echo '<table cellspacing="10" cellpadding="0" width="100%">';
 echo '<tr style="font-size:13px;">';
  echo '<td align="right">';

$days=30;
for ($n=0; $n<=$days; $n++) $arr_date[]=date('Y m d',strtotime("-$days day+$n day"));
$period=floor(strtotime("-$days day")/86400)*86400;

$max=0; $number=0;
$res=mysqli_query($db,"SELECT count(id), FROM_UNIXTIME(date,'%Y %m %d') AS dat
FROM ocenki WHERE date>'".$period."' GROUP BY dat ORDER BY dat");
while ($arr_stat[]=mysqli_fetch_array($res)) {
    if ($max<$arr_stat[$number][0]) $max=$arr_stat[$number][0];
    $number++;
}
$max=ceil($max/10)*10;
for ($n=1; $n<=11; $n++) {
    echo '<div style="height:40px;">'.round($max-$max*($n-1)/10).'</div>';
}
echo '</td><td valign="bottom">';
echo '<table style="background:url(1.png) no-repeat;padding:4px;" border="0"
    cellspacing="3" cellpadding="0">';
echo '<tr valign="bottom">';

for ($n=0; $n<=$number; $n++)
    $new_stat[array_search($arr_stat[$n]['dat'],$arr_date)]=$arr_stat[$n];


for ($n=1; $n<count($arr_date); $n++) {
    echo '<td class="column">';
    if (isset($new_stat[$n][0])) echo '<div style="height:'.
    floor(400/$max*$new_stat[$n][0]).'px;" title="'.$new_stat[$n][0].'"></div>';
    echo '</td>';
}

echo '</tr><tr style="font-size:13px;height:20px;" align="center">';
for ($n=1; $n<count($arr_date); $n++) echo '<td>'.substr($arr_date[$n],-2).'</td>';
array_splice($arr_stat,'');
array_splice($new_stat,'');
echo '</tr></table>';

echo '</td></tr></table>';
?>
 </body>
</html>