<?php
/* ЧТО ТАКОЕ АКВОД  */

/* Cкрипт содержит основную часть и место для статьи,
 а статья инжектируется в зависимости от переданного параметра GET*/

//получаем статью для отображения
$statiya=$_GET['statiya'];


//отображаем стартовые объявления
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/css/main.css" media="all">
<link rel="shortcut icon" href="/img/favicon.png" type="image/png">
<title>
ЧТО ТАКОЕ АКВОД
</title>
</head>

<body>
';


//Отображаем шапку

echo '

<div>

<a href="/" class="ssilka_v_punkte_menyu"> <!-- Отоюражаем логотип, который является ссылкой на главную страницу-->
    <img title="АКВОД - почвенный аккумулятор влаги" src="/img/2_akvod_logo_big.jpg" class="osnovnie_kartinki">
</a>

<span class="noselect zagolovok_stranitsi">Что такое<br> АКВОД?</span>

<img src="img/2_tulpanchik.png" title="Аквод способствует комфорту растений" class="osnovnie_kartinki, pomestit_sprava">
<br>
<a href="/" title="вернуться на главную страницу"><< на главную</a>

</div>
';

//Верхний разделитель
echo '
<img title="" src="/img/3_verhniy_razdelitel.png" class="razdelitel">
';


//Отображаем Основную часть
echo '

<table class="tablePage">
<tr>
    <td class="panel_menu">

    <div class="punkt_menu_wiki">
       <a href="index.php?statiya=wiki_akvod/wiki_akvod.htm" >
          Что такое АКВОД?
       </a>
    </div>

    <div class="punkt_menu_wiki">
       <a href="index.php?statiya=fasovka_i_tsena/fasovka_i_tsena.htm">
         АКВОД - фасовка
       </a>
    </div>

    <div class="punkt_menu_wiki">
        <a href="index.php?statiya=sposob_primeneniya_PAB/sposob_primeneniya_akvod.htm">
         Способы применения суперабсорбентов и их влияние на условия произрастания растений
        </a>
    </div>

    <div class="punkt_menu_wiki">
        <a href="index.php?statiya=rezultati_i_sertifikati/rezultati_i_sertifikati.htm">
         Результаты испытаний АКВОДа и сертификаты
        </a>
    </div>

    </td>


    <td class="pole-yacheyka_otobrazhenie_statyi"> <!-- Выводим собственно статью -->
        <span>
';

        include "$statiya";

echo '
        </span>
    </td>

</tr>
</table>

';


//Нижний разделитель
echo '
<img title="" src="/img/9_nizhniy_razdelitel.png" class="razdelitel">
';


//Отображаем подвал

include "../chasti_titula/podval.php";


?>