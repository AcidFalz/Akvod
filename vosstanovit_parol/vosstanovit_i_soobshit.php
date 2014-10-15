<?php
/*
 Скрипт отработки задачи восстановления пароля.

   1) Получает через GET электронную почту,
   2) проверяет, есть ли она в БД
   3) Если есть, отправляет на эту почту пароль к учетной записи
        и выдает сообщение, что на почту отправлен пароль.
   4) Если такой почты нет, выдает сообщение, что такой почты в базе нет.

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



//Получем через GET е-мэйл и экранируем его
$email=mysql_real_escape_string($_GET['email']);


//Проверяем есть ли уже такой е-мэйл в БД
$query = "SELECT `email_via_login`, `parol_k_uchetnoi_zapisi` FROM `Pokupateli_table` WHERE upper(`email_via_login`) LIKE upper('";
$query .= $email;
$query .= "')";

$result= mysql_query($query);
if(!$result){echo ('Ошибка проверки списка рассылки<br />'.mysql_error());}//проверяем выбрался ли


if(mysql_num_rows($result) == 0) { //Если в БД нет такой почты
    echo 'Такого е-мэйла нет базе данных. <br>Проверьте правильность е-мэйла.<br>';
    echo 'Введите ваш е-мэйл';
    echo '<input type="text" id="pole_vvoda">';
    echo '<input type="button" value="Напомнить пароль" onclick="napomnit();">';

    }
    elseif(mysql_num_rows($result)>0) { //Если в БД ткая почта есть, то сообщаем об этом и отправляем письмо с паролем.

        // Извлекаем результаты запроса
        $uchetnaya_zapis=mysql_fetch_array($result, MYSQL_ASSOC);
        /*После этого массив содержит такие поля:
            $uchetnaya_zapis = array (
                    email_via_login =>
                    parol_k_uchetnoi_zapisi =>
                    );
        */

        //=========================== Отправляем письмо ====================================
        $headers="From: AKVOD <akvod@ukr.net>\nReply-to:akvod@ukr.ne\nContent-Type:text/html; charset=\"utf-8\"\n";
            $e_mail=$uchetnaya_zapis['email_via_login'];

            $text_pisma='Здравствуйте,<br>';
            $text_pisma.='Для Вашей учетной записи ';
            $text_pisma.='<strong>'.$uchetnaya_zapis['email_via_login'].'</strong>.<br>';
            $text_pisma.='Установлен пароль: '.$uchetnaya_zapis['parol_k_uchetnoi_zapisi'].'<br>';
            $text_pisma.='Спасибо, что остаетесь с нами<br>';
            $text_pisma.='C уважением, Ваш АКВОД';


            $tema='Восстановление пароля на АКВОД';



        mail($e_mail, $tema, $text_pisma, $headers);

        //==============================================================================

        // Выдаем сообщение, что пароль отправлен
        echo '<span>Пароль к вашей учетной записи отправлен на Ваш е-мэйл.</span> <br>';
        echo '<span>Перейти в личный кабинет можно по ссылке ниже:</span><br>';
        echo '<a href="/lichniy_kabinet/index.php">Личный кабинет</a>';

    }




mysql_close($connection);