<?php
/* Скипт для просматривания доступных новостей
Из базы выбираются новости и отображаются заголовки в правой части экрана.
По клику на новости в центральной части экрана отображается её полный текст

Весь функцтонал скрипта реализован в одном файле.
При загрузке из базы выбирает список всех новостей.
Затем скрипт проверяет передан ли в качестве параметра номер новости.
Если номер был передан, то в основной части отображается соответствующая новость.
Если номер передан не был, или был передан некоректный номер, то отображается последняя новость.
*/




//УСТАНАВЛИВАЕМ СВЯЗЬ c БД
require_once ('../db/db_connect.php'); //подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли

//ВЫПОЛНЯЕМ ЗАПРОС ВСЕХ НОВОСТЕЙ
$query="SELECT * FROM `Novosti_table` where `opublikovana`=1 order by `data_vihoda_novosti` desc";//составить запрос
$result_all=mysql_query($query);//выполнить запрос
if(!$result_all){echo ('Ошибка выборки списка новостей<br />'.mysql_error());}//проверяем выбрались ли



//получаем или определяем номер новости для отображения
//если через GET ничего не передано, то берем последнюю новость

if(isset($_GET['new'])){
    $new['id_novosti']=$_GET['new'];
}
else {
    $query="SELECT `id_novosti` FROM `Novosti_table` WHERE `data_vihoda_novosti` = (select max(`data_vihoda_novosti`) from `Novosti_table` WHERE `opublikovana` = 1)";
    $rezult_last_record=mysql_query($query);
    if(!$rezult_last_record){echo ('Ошибка выборки последней новости<br />'.mysql_error());}//проверяем выбралась ли

    $new=mysql_fetch_array($rezult_last_record, MYSQL_ASSOC);
}


//Выполняем запрос отображаемой статьи
$query="SELECT * FROM Novosti_table WHERE id_novosti=".$new['id_novosti'];
$result_single=mysql_query($query);
if(!$result_single){echo ('Ошибка выборки списка новостей<br />'.mysql_error());}//проверяем выбрались ли

mysql_close($connection); //ЗАВЕРШАЕМ СОЕДИНЕНИЕ С БД

//Формируем ссылку на новость для отображения
$result_row_from_single=mysql_fetch_array($result_single, MYSQL_ASSOC);
$link_na_novost=$result_row_from_single['path_to_a_new'];









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
Новости
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

<span class="noselect zagolovok_stranitsi">НОВОСТИ</span>
<img src="img/persiki.jpg" title="Аквод способствует комфорту растений" class="osnovnie_kartinki, pomestit_sprava">
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

<table>
<tr>
    <td class="pole-yacheyka_otobrazhenie_statyi">  <!-- Выводим собственно новость -->

';

        include "$link_na_novost";

echo '

    </td>


    <td class="panel_menu"> <!-- Отображаем перечень новостей -->

';

    while($result_row=mysql_fetch_array($result_all, MYSQL_ASSOC)){
        echo '
            <div class="punkt_menu_wiki">
                <img src="'.$result_row['miniatyura_img'].'" title="" class="miniatura_novosti">
                <strong>'.
                '<a href="index.php?new='.$result_row['id_novosti'].'">'.
                $result_row['nazvanie_novosti']. //название новости
                '</a>'.
                '</strong><br />'.
                $result_row['anons_of_a_new']. //анонс новости
            '</div>
        ';
        
    }


echo '

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