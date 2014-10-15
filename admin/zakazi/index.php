<?php
/* Cкрипт-часть для просмотра и редактирования заказа по фильтрам
*/

//Стартуем сессию
session_start();

//ВЫБИРАЕМ ВОЗМОЖНЫЕ СТАТУСЫ ЗАКАЗА
//Подключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


//Составляем и выбираем перечень статусов
$query = "SELECT * FROM `Vozmozhnie_statusi_zakaza_table`";

//Выполняем запрос
$rezult=mysql_query($query);
if(!$rezult){echo 'Ошибка выборки возможных статусов заказа<br>'.mysql_error(); exit;}

//Сохраняем результат
$kolichestvo_statusov = mysql_num_rows($rezult);
for($i=0; $i<$kolichestvo_statusov; $i++){
    $spisok_statusov[]=mysql_fetch_array($rezult,MYSQL_ASSOC);
}

//Сохраняем в сессии
$_SESSION['spisok_statusov']=$spisok_statusov;

/* В итоге в массиве содержатся такие поля
    $spisok_statusov = array (
                `id_statusa`,
                `naimenovanie_statusa`,
                `opisanie_statusa`
                )
*/

//Закрываем соединение с БД
mysql_close();

/**/

/**/


//Сразу создаем всплывающее окно для отображения состава заказа и редактирования заказа
echo '<ul id="vsplivayuschee_okno">
        <ul class="knopka_krestik_zakrit" onclick="document.getElementById(\'vsplivayuschee_okno\').style.display=\'none\'">
            X
        </ul>
        <span id="mesto_v_okne_dlya_vivoda"></span>

      </ul>';

//ОТОБРАЖАЕМ ОФОРМЛЕНИЕ СТРАНИЦЫ И ПОСАДОЧНОЕ МЕСТО ДЛЯ ВЫВОДА РЕЗУЛЬТАТОВ ЗАПРОСА
echo '<ul class="otstupit_nemnogo_ot_krayov"><ul>Просмотр заказов по фильтрам</ul>';

echo '<form name="Forma_s_filtrami">';

//Выпадающий список для выбора даты заказа для фильтраци
echo '<select name="Select_s_datoy">';

echo '       <option selected value="ALL">Все даты</option>';

echo '</select>';

//Выпадающий список для выбора наименования покупателя для фильтраци
echo '<select name="Select_s_naimenovaniem_pokupatelya">';

echo '       <option selected value="ALL">Все Покупатели</option>';

echo '</select>';

//Выпадающий список для выбора статуса заказа для фильтраци
echo '<select name="Select_so_statusami" onchange="vibrat_dannie(this);">';
echo '       <option selected value="ALL">Все статусы</option>';
foreach($spisok_statusov as $ocherednoy_status){
    echo ' <option value="'.$ocherednoy_status['id_statusa'].'">'.$ocherednoy_status['naimenovanie_statusa'].'</option>';
}
echo '</select>';

echo '<input type="button" value="Отобразить заказы" onclick="vibrat_dannie(this);">';
echo '</form>';

//Посадочное место для вывода результатов запроса
echo '<ul id="rezultati_zaprosa_vivodit_syuda">';

/**/
 /**/

echo '</ul></ul>';



