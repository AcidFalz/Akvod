<?php
/** Скрипт вспомагательный для удаления новости
 * Получает через GET номер новости и удаляет её из базы.
 * В ответ, если все нормально, ничего не выдает,
 *иначе выдает ответ сервера
 */

if(!isset($_GET['id_novosti'])){
    echo 'Ошибка: Не указан новер новости.';
    exit;
}
//Подключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


//Формируем запрос
$query="DELETE FROM `Novosti_table` WHERE `id_novosti` =".mysql_real_escape_string($_GET['id_novosti']);

//Выполняем запрос
$rezult=mysql_query($query);


//Проверяем результат выполнения запроса
if(!$rezult){
    echo $query.'<br>';
    echo 'Ошибка удаления новости<br>'.mysql_error();
    echo '<input type="button"
                 value="Закрыть"
                 onclick="document.getElementById(\'vsplivayuschee_okno\').style.display=\'none\'">';
    exit;
}

mysql_close();

