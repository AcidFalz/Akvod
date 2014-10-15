<?php
/*Скрипт-часть для отображения списка зарегистрированных покупателей
*/

//поключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


//ВЫБИРАЕМ ИЗ БД ЗАРЕГИСТРИРОВАННЫХ ПОКУПАТЕЛЕЙ
$query = "SELECT `data_registratsii`,
                 `naimenovanie_pokupatelya`,
                 `email_via_login`
          FROM `Pokupateli_table`
          WHERE `email_via_login` != \"\" order by `data_registratsii`";

//Выполняем запрос
$rezult=mysql_query($query);
if(!$rezult){echo 'Ошибка выборки данных о зарегистрированных покупателях из БД<br>'.mysql_error(); exit;}

//Сохраняем результат
$kolichestvo_zaregistrirovannih_pokupateley = mysql_num_rows($rezult);
for($i=0; $i<$kolichestvo_zaregistrirovannih_pokupateley; $i++){
    $spisok_zaregistrirovannih_pokupateley[]=mysql_fetch_array($rezult,MYSQL_ASSOC);
}
/* В итоге в массиве содержатся такие поля
    $spisok_zaregistrirovannih_pokupateley = array (
                `data_registratsii`,
                `naimenovanie_pokupatelya`,
                `email_via_login`
                )
*/


//ВЫБИРАЕМ ИЗ БД ПОПИСАННЫХ ПОЛЬЗОВАТЕЛЙ
$query="SELECT * FROM `Podpischiki_na_novosti_table`";

$rezult=mysql_query($query);
if(!$rezult){echo 'Ошибка выборки данных о подписчиках из БД<br>'.mysql_error(); exit;}

$spisok_podpischikov = array();
$kolichestvo_podpischikov = mysql_num_rows($rezult);
for($i=0;$i<$kolichestvo_podpischikov;$i++){
    $stroka = mysql_fetch_array($rezult, MYSQL_ASSOC);
    $spisok_podpischikov[$i]= $stroka['e-mail_podpischika'];
}
/* В результате массив содержит
    $spisok_podpischikov = array (
            id_podpischika,
            e-mail_podpischika
        )
*/

//ОТОБРАЖАЕМ РЕЗУЛЬТАТ

echo '<ul class="otstupit_nemnogo_ot_krayov">';
echo '  <select disabled>';
echo '      <option selected disabled =1>Сортировать по дате регистрации</option>';
echo '      <option disabled value=2>Сортировать по Имени покупателя(Наименованию)</option>';
echo '  </select>';

echo '<span class="snoska_sprava">';
echo '<hr>';
echo 'Всего зарегистрировано пользователей - ';
echo $kolichestvo_zaregistrirovannih_pokupateley;
echo '<hr>';
echo 'Всего подписано на рассылку - ';
echo $kolichestvo_podpischikov;
echo '<hr>';
echo '</span>';

echo '  <table>';
echo '<caption class="zagolovok_spiska">Список зарегистрированных покупателей</caption>';
echo '<thead>';
echo '  <tr id="shapka_spiska">
            <td>
                Дата регистрации
            </td>
            <td>
                Имя покупателя(Наименование)
            </td>
            <td>
                Включен ли в рассылку?
            </td>
        </tr>';
echo '</thead>';
echo '<tbody>';
foreach ($spisok_zaregistrirovannih_pokupateley as $ocherednoy_pokupatel) {
    echo '<tr>';
    echo '  <td>';
    echo $ocherednoy_pokupatel['data_registratsii'];
    echo '  </td>';
    echo '  <td>';
    echo $ocherednoy_pokupatel['naimenovanie_pokupatelya'];
    echo '  </td>';
    echo '  <td>';
    if(in_array($ocherednoy_pokupatel['email_via_login'],$spisok_podpischikov))echo 'Да'; else  echo 'Нет';
    echo '  </td>';
    echo '</tr>';
}
echo '</tbody>';

echo '  </table>';
echo '</ul>';