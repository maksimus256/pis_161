<?php
require('class.php');
$Page = new Page();
$Page -> header();
$Page -> connect();
$tireqty = $_POST['tireqty'];
$oilqty = $_POST['oilqty'];
$sparkqty = $_POST['sparkqty'];
$address = $_POST['address'];
$fio = $_POST['fio'];
$Page -> processorder($tireqty,$oilqty,$sparkqty,$fio,$address);
$Page -> footer();

?>