<?php
/* Основной скрипт ресурса Аквод*/

//отображаем стартовые объявления
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/main.css" media="all">
<link rel="shortcut icon" href="/img/favicon.png" type="image/png">
<title>
АКВОД - почвенный аккумулятор влаги
</title>
</head>

<body>
';

//Отображаем шапку сайта
echo '
<div>
<span id="nazvanie_sayta" class="noselect">АКВОД</span>
<img title="АКВОД - почвенный аккумулятор влаги" src="img/2_akvod_logo_big.jpg" class="osnovnie_kartinki" id="logo_sayta">
</div>
';


//Верхний разделитель
echo '


';

//<div class="razdelitel">
//Отображаем строку меню
echo '
<table class="glavnoe_menu">
    <tr>
            <td>
                <a href="chto_takoe_akvod/index.php?statiya=wiki_akvod/wiki_akvod.htm" class="ssilka_v_punkte_menyu">
                    <span class="knopka_glavnoe_menu" title="Что такое АКВОД">Что такое<br> АКВОД</span>
                </a>
            </td>

            <td>
                <a href="novosti" class="ssilka_v_punkte_menyu">
                    <span class="knopka_glavnoe_menu" title="Новости">НОВОСТИ</span>
                </a>
            </td>

            <td>
                <a href="zakazat/" class="ssilka_v_punkte_menyu">
                    <span class="knopka_glavnoe_menu" title="ЗАКАЗАТЬ">ЗАКАЗАТЬ</span>
                </a>
            </td>

            <td>
                <a href="kontakty/" class="ssilka_v_punkte_menyu">
                    <span class="knopka_glavnoe_menu" title="Контакты">КОНТАКТЫ</span>
                </a>
            </tr>
    </tr>
</table>

';

//Отображаем Основную часть
echo '
<img title="АКВОД - почвенный аккумулятор влаги" src="img/8_osnovnaya_chast.png" class="razdelitel">
';



include "chasti_titula/podval.php";



?>