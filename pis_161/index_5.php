﻿<?php 

  require ('page_5.inc');
  $homepage = new Page();
  $homepage -> SetContent('<p> Лабораторная работа по теме ООП на РНР </p>');
  $homepage -> SetTitle('Лабораторная работа по теме: ООП на РНР');

  $homepage -> Setnazvanie('Лабораторные работы по курсу Разработка интернет приложений в сфере коммерциии посредством PHP и MySQL <br> Студента группы ПИ-161: Салтымаков М.В. <br> Проверил: к.т.н. доц. Назимов А.С.');

  $homepage -> Display();

?>
