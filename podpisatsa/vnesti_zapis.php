<?php
/* Вспомагательный Скрипт добавления записи о подписчике в БД */


/*
1) Подключаемся к БД
2) Проверяем есть ли такой е-мэйл уже в БД
3) если есть, то выдаем сообщение, что УЖЕ ЕСТЬ ТАКОЙ
4) если нет, то вносим запись в БД

Получаем через $_GET['email'] е-мэйл для добавления.
Сообщения выводим в основной поток.
*/





//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);



//УСТАНАВЛИВАЕМ СОЕДИНЕНИЕ С БАЗОЙ,

include ("../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


//Получем е-мэйл для внесения и экранируем введенные данные
$email=mysql_real_escape_string($_GET['email']);


//Проверяем есть ли уже такой е-мэйл в БД
$query = "SELECT * FROM `Podpischiki_na_novosti_table` WHERE `e-mail_podpischika`='";
$query .= $email;
$query .= "'";


$result= mysql_query($query);
if(!$result){echo ('Ошибка проверки списка рассылки<br />'.mysql_error());}//проверяем выбрался ли

if(mysql_num_rows($result) > 0) echo 'Этот Е-мэйл уже подписан на новости';
    else {

    //Формируем запрос для вставки
    $query = "INSERT INTO
                    `Podpischiki_na_novosti_table`
                    (`id_podpischika`,
                     `e-mail_podpischika`)
                VALUES
                    (NULL,
                    '";
     $query .= $email;
     $query .= "')";

    $result=mysql_query($query);//выполнить запрос
    if(!$result){echo ('Ошибка вставки е-мэйла в список рассылки<br />'.mysql_error());}//проверяем выбрались ли
    else echo 'Е-мэйл успешно добавлен в список рассылки';

    }

echo '<dir><a href="/index.php" title="Вернуться на Главную"><= Вернуться на главную</a> </dir>';


mysql_close($connection);

unset ($_GET['email']);
unset ($connection);
unset ($db_select);
unset ($query);
unset ($result);


?>