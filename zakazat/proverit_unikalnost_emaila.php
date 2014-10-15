<?php
/* Премежуточный скрипт для проверки уникальности введенного е-мэйла*/

/* В данный скрипт передается только е-мэйл. Скрипт выбирает из БД вес существующие е-мэйлы записей с введенным паролем.
Затем сопоставляет преверяемый е-мэйл с существующими е-мэйлами.
Если е-мэйл уникален, то вызывается следующий по алгоритму скрипт, который добавит запись о новом пользователе и его заказе,
При этом передается е-мэйл и пароль.
Если  е-мэйл не уникален, то повторно вызывается скрипт Создать_Учетную_Запись.ПХП и передается флаг $uzhe_est_takoy_email
*/




//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);

//Стартуем сессию
session_start();



//  1) Устанавливаем соединение с БД
include ("../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли



//  2) Выбираем из базы существующие логины недоступные для новой учетной записи
    $sql="SELECT `email_via_login` FROM `Pokupateli_table` WHERE CHAR_LENGTH( `parol_k_uchetnoi_zapisi` ) > 0";
    $result=mysql_query($sql); //выбираем данные из базы
    if(!$result){echo ('Ошибка выборки даных о е-мэйлах<br />'.mysql_error()).'<br>';}//проверяем выбрались ли





//  3) Сохраняем результаты запроса в массиве
$kolichestvo_isnuyuchih_email=mysql_num_rows($result);
$isnuyuchi_emaily = array();
for($i=1; $i<=$kolichestvo_isnuyuchih_email; $i++){
    $odin_is_isnuyuchih_emailov=mysql_fetch_array($result, MYSQL_ASSOC);
    $isnuyuchi_emaily[]=$odin_is_isnuyuchih_emailov['email_via_login'];
}






//ЗАВЕРШАЕМ СОЕДИНЕНИЕ С БД
mysql_close($connection);

//print_r($isnuyuchi_emaily);

//Проверяем уникален ли е-мэйл
if(in_array($_POST['email_via_login'], $isnuyuchi_emaily)) {

    echo '<script language="JavaScript">
           // alert("uzhe_est_takoy_email=true");
            document.location.href="/zakazat/sozdat_uchetnuyu_zapis.php?uzhe_est_takoy_email=true"
          </script>';
} else {
    $_SESSION['email_via_login'] = $_POST['email_via_login'];
    $_SESSION['parol'] = $_POST['parol'];
    echo '<script language="JavaScript">
            //alert("to sohranit_zakaz.php");
            document.location.href="/zakazat/sohranit_zakaz.php"
          </script>';
}



