<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Максим
 * Date: 02.10.13
 * Time: 21:10
 * To change this template use File | Settings | File Templates.
 */

session_start();


//БД уже подключена

//УСТАНАВЛИВАЕМ СОЕДИНЕНИЕ С БАЗОЙ,
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


//Проверяем парвильно ли введен старый пароль

//Экранируем пользовательский ввод
$stariy_parol = mysql_real_escape_string($_GET['sp']);
$noviy_parol = mysql_real_escape_string($_GET['np']);


$query="SELECT `id_admina`
        FROM `Administratori_table`
        WHERE `id_admina`=".$_SESSION['id_admina']."
            and
              `parol`= MD5('".$stariy_parol."')";


$rezult=mysql_query($query);
if(!$rezult){echo "Ошибка выборки из БД"; echo mysql_error(); exit;}



//Если не правильно, то выдаем сообщение об этом и выводим повторно форму
if(mysql_num_rows($rezult)==0) {
    echo '<form method="get" action="smenit_parol.php" name="Forma_smeni_parolya">
            <span>
                Введите старый пароль<br>
                <input type="password" name="Stariy_parol"> <span class="error_massage">Старый пароль введен неверно</span> <br>
            </span>

            <span>
                Введите новый пароль<br>
                <input type="password" name="Noviy_parol"><br>
            </span>

            <span>
                Введите новый пароль ещё раз<br>
                <input type="password" name="Noviy_parol_povtor"><br>
            </span>
            <input type="button" value="Сменить пароль" onclick="proverit_parol_i_smenit(this);">
          </form>';
    exit;

}


//Если правильно, то формируем запрос на изменение пароля и вносим запись в БД

$query = "UPDATE `Administratori_table`
          SET `parol`= MD5('".$noviy_parol."')
          WHERE `id_admina`=".$_SESSION['id_admina'];

$rezult = mysql_query($query);
if(!$rezult) {echo 'Ошибка смены пароля'; echo mysql_error(); exit;}




//Затем выдаем сообщение о успешной смене пароля

echo '<span class="forma_v_adminke otstupit_nemnogo_ot_krayov">Пароль успешно изменен</span>';

mysql_close();