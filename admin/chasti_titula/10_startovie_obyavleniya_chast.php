<?php
/* Часть со стартовыми объявлениями

    Стартовые объявления:
         Показываем ошибки,
         стартуем сесию,
         проверяем залогинен ли,
         поключаем БД
         и выбираем необходимые данные.*/


//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);


//Стартуем сессию
session_start();


//Проверяем залогинен ли?
    /*Если не залогинен, то переправляем на скрипт авторизации
    и прекращаем выполнения скрипта
    */
if(!isset($_SESSION['id_admina'])){
    echo '<script language="JavaScript">document.location.href="/admin/login/zayti.php"</script>';
    exit;
}



//УСТАНАВЛИВАЕМ СОЕДИНЕНИЕ С БАЗОЙ,

include ("../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли

//Выбираем доступные пункты меню
$query = "SELECT * FROM `Punkti_menu_adminki_table` order by `nomer_punkta_menu`";
$rezult = mysql_query($query);
if(!$rezult)echo 'Ошибка выборки списка пунктов меню<br>'.mysql_error();


//Сохраняем результаты в переменной сессии
$kolichestvo_punktov = mysql_num_rows($rezult)+1;
$dostupnie_punkti_menu = array();
for($i=1;$i<$kolichestvo_punktov; $i++){
    $m = mysql_fetch_array($rezult,MYSQL_ASSOC);
    $dostupnie_punkti_menu[$m['nomer_punkta_menu']] = $m;
}

$_SESSION['dostupnie_punkti_menu'] = $dostupnie_punkti_menu;



