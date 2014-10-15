<?php
/* Скрипт, отображающий контактную информацию*/



//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);







//ТЕПЕРЬ ОТОБРАЖАЕМ СТРАНИЦУ
//отображаем стартовые объявления
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/css/main.css" media="all">
<link rel="shortcut icon" href="/img/favicon.png" type="image/png">
<title>
Контакты
</title>



<script type="text/javascript" language="javascript">


</script>



</head>

<body>
';


//Отображаем шапку

echo '

<div>

<a href="/index.php"  class="ssilka_v_punkte_menyu"> <!-- Отоюражаем логотип, который является ссылкой на главную страницу-->
    <img title="АКВОД - почвенный аккумулятор влаги" src="/img/2_akvod_logo_big.jpg" class="osnovnie_kartinki">
</a>

<span class="noselect zagolovok_stranitsi">Контакты</span>

<img src="/kontakty/img/vinograd.jpg" title="Аквод способствует комфорту растений" class="osnovnie_kartinki, pomestit_sprava">

<br>
<a href="/" title="вернуться на главную страницу"><< на главную</a>

</div>
';



//Верхний разделитель
echo '
<img title="" src="/img/3_verhniy_razdelitel.png" class="razdelitel">
';

echo '<div class="abzats_kontakty">';

echo '<strong>Контактна информація</strong> <br>';
echo ' Приватне підприємство “НАГАНІ”<br>';
echo '03057 м. Київ, вул. Довженка,10 <br>';
echo '(050)334-59-32, (067)98-38-499 Сергій Георгійович<br>';
echo 'е-mail:rissa@voliacable.com<br><br>';

echo '<img src="img/GreenLand_logo.jpg">';





echo '</div>';












//Нижний разделитель
echo '
<img title="" src="/img/9_nizhniy_razdelitel.png" class="razdelitel">
';


//Отображаем подвал
include "../chasti_titula/podval.php";



