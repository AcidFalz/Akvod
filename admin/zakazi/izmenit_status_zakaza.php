<?php
/**
 Вспомагательный скрипт для внесения в БД отредактированного статуса заказа*/
/*
  /admin/zakazi/izmenit_status_zakaza.php?n=NNN&s=SSS&comm=CCC
 */


//Подключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли

//формируем запрос
$query="UPDATE `Zakazi_table`
        SET `id_statusa_zakaza`=".mysql_real_escape_string($_GET['s']).",
            `primechanie_k_zakazu`='".mysql_real_escape_string($_GET['comm'])."'
        WHERE `id_zakaza`=".mysql_real_escape_string($_GET['n']);


//Выполняем запрос
$rezult=mysql_query($query);
if(!$rezult){echo 'Ошибка сохранения статуса заказа<br>'.mysql_error(); exit;}

