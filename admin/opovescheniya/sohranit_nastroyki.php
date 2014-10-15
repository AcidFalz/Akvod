<?php
/**
Вспомагательный скрипт для сохранения в БД настроек оповещения менеджера о новом заказе
 */

//стартуем сессию
session_start();


//готовим даные для сохранения в БД
if($_GET['po_sms']=="true") $uvedomlyat_na_telephon="checked";
else $uvedomlyat_na_telephon="";

if($_GET['po_e']=="true") $uvedomlyat_na_email="checked";
else $uvedomlyat_na_email="";



//Подключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


//Составляем запрос
$query="UPDATE `Administratori_table`
        SET
            `uvedomlyat_na_telephon`=\"";
$query.=$uvedomlyat_na_telephon;
$query.="\",";
$query.="   `uvedomlyat_na_email`=\"";
$query.=$uvedomlyat_na_email;
$query.="\" WHERE `id_admina`=";
$query.=$_SESSION['id_admina'].";";


//Выполняем запрос
$rezult=mysql_query($query);
if(!$rezult){echo 'Ошибка вставки данных в БД<br>'.mysql_error(); exit;}

//Изменяем настройки в переменных сессии
$_SESSION['dannie_o_admine']['uvedomlyat_na_telephon']=$uvedomlyat_na_telephon;
$_SESSION['dannie_o_admine']['uvedomlyat_na_email']=$uvedomlyat_na_email;

echo '<ul class="forma_v_adminke otstupit_nemnogo_ot_krayov">Настройки оповещения сохранены</ul>';

