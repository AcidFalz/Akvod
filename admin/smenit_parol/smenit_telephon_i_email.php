<?php
/* Подгружаемый скрипт сохранения в базе нового телефона и е-мэйла */

//Стартуем сессию
session_start();


//УСТАНАВЛИВАЕМ СОЕДИНЕНИЕ С БАЗОЙ,
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


//Получаем данные через GET и экранируем пользовательский ввод
$telephon = mysql_real_escape_string($_GET['t']);
$email = mysql_real_escape_string($_GET['e']);

//формируем запрос
$query ="UPDATE
            `Administratori_table`
        SET
            `e-mail`='".$email."',
            `telephon`='".$telephon."'
        WHERE `id_admina`=".$_SESSION['id_admina'];

//Выполняем запрос и проверяем ответ сервера
$rezult = mysql_query($query);
if(!$rezult){echo "Ошибка записи в БД<br>"; echo mysql_error(); exit;}

//Рапортуем о успешном внесении данных в базу
echo '<ul class="forma_v_adminke otstupit_nemnogo_ot_krayov">
        <strong>Данные успешно внесены</strong><br>
        Теперь установлен телефон: ';
echo    $telephon;
echo    '<br>';
echo    'И е-мэйл: ';
echo    $email;

echo ' </ul>';

//Отображаем измененные телефон и е-мэйл в переменных сессии
$_SESSION['e-mail'] = $_SESSION['dannie_o_admine']['e-mail'] = $email;
$_SESSION['dannie_o_admine']['telephon'] = $telephon;


mysql_close();



