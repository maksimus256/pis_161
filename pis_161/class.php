<?php
class Page
{
function header()
{
	require('header.inc');
}
function footer(){
	require('footer.inc');
}
function orderform(){
echo <<<HTML
<html>
<head>
  <title>Автозапчасти от Боба</title>
</head>

<body>
<h1>Лабораторная работа № 3.1 по теме сохранение и востановление данных посредством СУРБД - MySQL</h1>
<h2>Автозапчасти от Боба</h2>
<h3>Форма заказа</h3>

<form action="processorder_3_1.php" method=post>
<table border=0>
<tr bgcolor=#cccccc>
  <td width=150>Товар</td>
  <td width=15>Количество</td>
</tr>
<tr>
  <td>Автопокрышки</td>
  <td align="left"><input type="text" name="tireqty" size= "3" maxlength="3"></td>
</tr>
<tr>
  <td>Машинное масло</td>
  <td align= "left"><input type="text" name="oilqty" size="3" maxlength="3"></td>
</tr>
<tr>
  <td>Свечи зажигания</td>
  <td align="left"><input type="text" name="sparkqty" size= "3" maxlength="3"></td>
</tr>

<tr>
  <td>ФИО клиента</td>
  <td align="left"><input type="text" name="fio" size= "40" maxlength="40"></td>
</tr>

<tr>
  <td>Адрес доставки</td>
  <td align="left"><input type="text" name="address" size= "40" maxlength="40"></td>
</tr>

<tr>
  <td colspan="2" align="center"><input type="submit" value= "Отправить заказ"></td>
</tr>

</table>
</form>
</body>
</html>
HTML;
}
function connect(){
global $link;
$hostname="localhost";
$user="lab3";
$password="lab3";
$db="lab3";
$link = mysqli_connect($hostname, $user, $password,$db);
if(!$link)
{
echo "<br> Не могу соединиться с сервером базы данных <br>";
exit();
}

}
function processorder($tireqty,$oilqty,$sparkqty,$fio,$address){
global $link;
echo <<<HTML
<html>
<head>
  <title>Автозапчасти от Боба - Результаты заказа</title>
</head>
<body>
<h1>Лабораторная работа № 3.1 по теме сохранение и востановление данных посредством СУРБД - MySQL</h1>
<h2>Автозапчасти от Боба</h2>
<h3>Результаты заказа</h3>
HTML;
$totalqty = 0;
  $totalqty += $tireqty;
  $totalqty += $oilqty;
  $totalqty += $sparkqty;
  $totalamount = 0.00;
  define('TIREPRICE', 100);
  define('OILPRICE', 10);
  define('SPARKPRICE', 4);
  $date = date('H:i, jS F');
  echo '<p>Заказ обработан в ';
  echo $date;
  echo '<br />';
  echo '<p>Список вашего заказа:';
  echo '<br />';

  if( $totalqty == 0 )
  {
    echo 'Вы ничего не заказали на предыдущей странице!<br />';
  }else{
    if ( $tireqty>0 )
      echo $tireqty.' автопокрышек<br />';
    if ( $oilqty>0 )
      echo $oilqty.' бутылок с маслом<br />';
    if ( $sparkqty>0 )
      echo $sparkqty.' свечей зажигания<br />';
  }
  $total = $tireqty * TIREPRICE + $oilqty * OILPRICE + $sparkqty * SPARKPRICE; 
  $total=number_format($total, 2, '.', ' ');
  echo '<P>Итого по заказу: '.$total.'</p>';
  echo '<P>ФИО клиента: '.$fio.'</p>';
  echo '<P>Адрес доставки: '.$address.'<br />';
  $outputstring = $date."\t".$tireqty." автопокрышек \t".$oilqty." масла\t"
                  .$sparkqty." свечей\t\$".$total
                  ."\t Адрес доставки товара\t ". $address."\t ФИО клиента:".$fio." \n";

  // Открыть файл для добавления
$date_1=date("Y-m-d H:i:s",mktime());
$query="insert into zakaz (fio,adress,data) values ('$fio','$address','$date_1')";
$result=mysqli_query($link, $query);
$query_1="select zakaz.id  from zakaz where  zakaz.fio='$fio' ";
$result_1=mysqli_query($link, $query_1);
while ($row=mysqli_fetch_array($result_1)){
$id=$row["id"];
}
$query="insert into tovar (id, tiregty,oilgty,sparkgty) values ('$id','$tireqty','$oilqty','$sparkqty')";
$result=mysqli_query($link, $query);
echo '<p>Заказ сохранен.</p>'; 
echo '<a href="vieworders_3_1.php"> Интерфейс персонала для просмотра файла заказов </a>
</body>
</html>';
}

function vieworders(){
	$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
	echo <<<HTML
	<html>
<head>
  <title>Автозапчасти от Боба - Заказы клиентов</title>
</head>
<body>
<h1>Лабораторная работа № 3.1 по теме сохранение и востановление данных посредством текстовых файлов</h1>
<h2>Автозапчасти от Боба</h2>
<h3>Заказы клиентов</h3>
HTML;

$hostname="localhost";
$user="lab3";
$password="lab3";
$db="lab3";
$link = mysqli_connect($hostname, $user, $password,$db);
if(!$link)
{
//echo "<br> Не могу соединиться с сервером базы данных <br>";
exit();
}
$query_1="select zakaz.id, zakaz.fio, zakaz.adress, zakaz.data, tovar.id, tovar.tiregty, tovar.oilgty, tovar.sparkgty FROM zakaz, tovar where  zakaz.id=tovar.id order by zakaz.data";
$result_1=mysqli_query($link, $query_1);
echo "<table border=1 color=black width=100% height=100%>
<tr>
<td><b>№</b></td><td><b>ФИО</b></td><td><b>Адрес</b></td><td><b>Дата заказа</b></td><td><b>покрышки</b></td><td><b>масла</b></td><td><b>свечи</b></td>
";

while ($row_1=mysqli_fetch_array($result_1)){
$id=$row_1["id"];
$fio=$row_1["fio"];
$adress=$row_1["adress"];
$data=$row_1["data"];
$tireqty=$row_1["tiregty"];
$oilqty=$row_1["oilgty"];
$sparkqty=$row_1["sparkgty"];
echo "
<tr>
<td>  $id  </td><td> $fio </td><td> $adress </td><td> $data </td><td> $tireqty </td><td> $oilqty </td><td> $sparkqty </td>
</tr>
";
}
echo "
</table>
</body>
</html>
";
}
}