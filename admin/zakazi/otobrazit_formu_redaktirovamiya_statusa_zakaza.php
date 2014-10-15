<?php
/**
 Вспомагательный скрипт для отображения формы редактирования статуса заказа */
//Получает через GET['n'] номер заказа

session_start();

//Подключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли

//формируем запрос
$query="SELECT t1.id_zakaza AS nomer_zakaza,
        t1.data_zakaza,
        t5.naimenovanie_pokupatelya,
        SUM( t2.kolichestvo_shtuk_tovara_v_zakaze * t3.tsena ) AS summa_zakaza,
        t4.naimenovanie_statusa AS status_zakaza,
        t1.primechanie_k_zakazu as commentariy
        FROM Zakazi_table AS t1
        JOIN Sostav_zakaza_table AS t2 ON t1.id_zakaza = t2.id_zakaza
        JOIN Tovari_table AS t3 ON t2.id_tovara = t3.id_tovara
        JOIN Vozmozhnie_statusi_zakaza_table AS t4 ON t1.id_statusa_zakaza = t4.id_statusa
        join Pokupateli_table as t5 on t5.id_pokupatelya = t1.id_pokupatelya
        WHERE t1.id_zakaza=".mysql_real_escape_string($_GET['n'])."
        GROUP BY t1.id_zakaza";

$rezult=mysql_query($query);
if(!$rezult){echo 'Ошибка выборки состава заказа<br>'.mysql_error(); exit;}
$sostav_zakaza=mysql_fetch_array($rezult,MYSQL_ASSOC);
/*Массив содержит
    $sostav_zakaza = array (
            nomer_zakaza
            data_zakaza
            naimenovanie_pokupatelya
            summa_zakaza
            status_zakaza
            commentariy
                )
*/
//Получаем из сессии список статусов
$spisok_statusov=$_SESSION['spisok_statusov'];



//Выводим форму

//Состав заказа выводим в виде таблицы
    echo '<table>';

    echo '<caption><strong>Состав заказа</strong></caption>';
    echo '<thead>'; //Строка заголовков
    echo '<tr>';
    echo    '<td></td>';
    echo    '<td class="tekst_po_centru yacheyka_tablitsi_zakazi">Дата заказа</td>';
    echo    '<td class="tekst_po_centru yacheyka_tablitsi_zakazi">Наименование покупателя</td>';
    echo    '<td class="tekst_po_centru yacheyka_tablitsi_zakazi">Сумма заказа</td>';
    echo    '<td class="tekst_po_centru yacheyka_tablitsi_zakazi">Статус заказа</td>';
    echo '</tr>';
    echo '</thead>';//Конец строки заголовков


    //Выводим состав заказа
        echo '<tr>';
        echo    '<td class="tekst_po_centru yacheyka_tablitsi_zakazi">№'.$sostav_zakaza['nomer_zakaza'].'</td>';
        echo    '<td class="tekst_po_centru yacheyka_tablitsi_zakazi">'.$sostav_zakaza['data_zakaza'].'</td>';
        echo    '<td class="tekst_sleva yacheyka_tablitsi_zakazi">'.$sostav_zakaza['naimenovanie_pokupatelya'].'</td>';
        echo    '<td class="tekst_po_centru yacheyka_tablitsi_zakazi">'.$sostav_zakaza['summa_zakaza'].' грн</td>';
        echo    '<td class="tekst_po_centru yacheyka_tablitsi_zakazi">'.$sostav_zakaza['status_zakaza'].'</td>';
        echo '</tr>';

    echo '</table><hr>';

echo '<form name="Forma_redaktirovaniya_statusa">';
echo '<input type="hidden" name="nomer_zakaza" value="'.$sostav_zakaza['nomer_zakaza'].'">';
echo '<ul>Изменить статус на: ';
//Выпадающий список для выбора статуса заказа для фильтраци
echo '<select name="Select_so_statusami">';

foreach($spisok_statusov as $ocherednoy_status){

    echo ' <option value="'.$ocherednoy_status['id_statusa'].'"';
    if($ocherednoy_status['naimenovanie_statusa'] == $sostav_zakaza['status_zakaza']) echo ' selected ';
    echo '>'.$ocherednoy_status['naimenovanie_statusa'].'</option>';

}
echo '</select></ul><br>';

echo '<ul>Введите коментарий к заказу:<br>';
echo '<textarea rows="9" cols="60" name="commentariy">'.$sostav_zakaza['commentariy'].'</textarea></ul>';

echo '<input class="knopka_Ok" type="button" value="Отмена" onclick="document.getElementById(\'vsplivayuschee_okno\').style.display=\'none\';">';
echo '<input class="knopka_sohranit" type="button" value="Сохранить" onclick="izmenit_status_zakaza(this);">';
echo '</form>';