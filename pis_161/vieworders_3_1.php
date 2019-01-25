<?php
require('class.php');
$Page = new Page();
$Page -> header();
$Page -> connect();
$Page -> vieworders();
$Page -> footer();

?>