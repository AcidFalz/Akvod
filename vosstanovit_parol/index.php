<?php
/* Скрипт страницы восстановления пароля

    Запрашивает электронную почту, вызывает скрипт отработки vosstanovit_i_soobshit,
    передает через GET почту и выводит ответ скрипта на странице.

    Реализован через  XMLHTTPRequest()

*/



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
Восстановить пароль
</title>



<script type="text/javascript" src="../js/glavnaya.js"></script>



</head>

<body>
';


//Отображаем шапку

echo '

<div>

<a href="/" class="ssilka_v_punkte_menyu"> <!-- Отображаем логотип, который является ссылкой на главную страницу-->
    <img title="АКВОД - почвенный аккумулятор влаги" src="/img/2_akvod_logo_big.jpg" class="osnovnie_kartinki">
</a>

<span class="noselect zagolovok_stranitsi_pomenshe">АКВОД - почвенный<br> аккумулятор влаги</span>
<img src="img/abrikoska.jpg" title="Аквод способствует комфорту растений" class="osnovnie_kartinki, pomestit_sprava">
<br>
<a href="/" title="вернуться на главную страницу"><< на главную</a>


</div>
';



//Верхний разделитель
echo '
<img title="" src="/img/3_verhniy_razdelitel.png" class="razdelitel">
';




echo '<form class="pomestit_po_centru" id="forma_vvoda">'; //ФОрма ввода е-мэйла для подписки на новости

echo 'Введите ваш е-мэйл';
echo '<input type="text" id="pole_vvoda">';
echo '<input type="button" value="Напомнить пароль" onclick="napomnit();">';



echo '</form>';








//Нижний разделитель
echo '
<img title="" src="/img/9_nizhniy_razdelitel.png" class="razdelitel">
';


//Отображаем подвал
include "../chasti_titula/podval.php";
