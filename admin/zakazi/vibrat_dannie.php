<?php
/**
Вспомагательный скрипт длz выбора списка заказов их БД по указанным критериям.
 *
/admin/zakazi/vibrat_dannie.php?id_pokupatelya=iii&data_zakaza=ddd&id_statusa_zakaza=sss
 *Получает через GET параметры запроса и возвращает массив с результатом через ECHO */

//Подключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


//Перед запросом формируем строку условий WHERE
//Её мы составляем из данных GET
/*
$_GET['id_pokupatelya'];
$_GET['data_zakaza'];
$_GET['id_statusa_zakaza'];
*/
if($_GET['id_pokupatelya']!="ALL"){
    $pervoe_uslovie="t1.id_pokupatelya='".mysql_real_escape_string($_GET['id_pokupatelya'])."'";
}else $pervoe_uslovie=1;

if($_GET['data_zakaza']!="ALL"){
    $vtoroe_uslovie="t1.data_zakaza='".mysql_real_escape_string($_GET['data_zakaza'])."'";
}else $vtoroe_uslovie=1;

if($_GET['id_statusa_zakaza']!="ALL"){
    $tretie_uslovie="t1.id_statusa_zakaza='".mysql_real_escape_string($_GET['id_statusa_zakaza'])."'";
}else $tretie_uslovie=1;

$stroka_usloviy=$pervoe_uslovie." and ".$vtoroe_uslovie." and ".$tretie_uslovie;

/**/
//Выполняем запрос полного перечня заказов
$query = "SELECT \n"
        . "	t1.id_zakaza AS nomer_zakaza, \n"
        . "	t1.data_zakaza, \n"
        . " t5.naimenovanie_pokupatelya,\n"
        . "	SUM( t2.kolichestvo_shtuk_tovara_v_zakaze * t3.tsena ) AS summa_zakaza, \n"
        . "	t4.naimenovanie_statusa AS status_zakaza\n"
        . "FROM Zakazi_table AS t1\n"
        . "JOIN Sostav_zakaza_table AS t2 ON t1.id_zakaza = t2.id_zakaza\n"
        . "JOIN Tovari_table AS t3 ON t2.id_tovara = t3.id_tovara\n"
        . "JOIN Vozmozhnie_statusi_zakaza_table AS t4 ON t1.id_statusa_zakaza = t4.id_statusa\n"
        . "join Pokupateli_table as t5 on t5.id_pokupatelya = t1.id_pokupatelya\n"
        . "WHERE ".$stroka_usloviy."\n"
        . "GROUP BY t1.id_zakaza";


//Выполняем запрос
$rezult=mysql_query($query);
if(!$rezult){echo 'Ошибка выборки списка заказов<br>'.mysql_error(); exit;}

//Сохраняем результат
$kolichestvo_zakazov = mysql_num_rows($rezult);
for($i=0; $i<$kolichestvo_zakazov; $i++){
    $spisok_zakazov[]=mysql_fetch_array($rezult,MYSQL_ASSOC);
}
/* В итоге в массиве содержатся такие поля
    $spisok_zakazov = array (
                `nomer_zakaza`,
                `data_zakaza`,
                `naimenovanie_pokupatelya`,
                `summa_zakaza`,
                `status_zakaza`,
                )
*/

//Закрываем соединение с БД
mysql_close();

/**/

if(isset($spisok_zakazov)) {

echo '<hr>';
echo '<table>';

    echo '<caption class="strong">Список заказов</caption>';
    echo '<thead>';
    echo '  <tr class="tekst_po_centru">
                <td>
                    п/п
                </td>
                <td>
                    Номер заказа
                </td>
               <td>
                    Дата заказа
                </td>
                <td>
                    Имя покупателя (Наименование)
                </td>
                <td>
                    Сумма заказа
                </td>
                <td>
                    Статус заказа
                </td>
               <td>

                </td>
            </tr>';
    echo '</thead>';


    $i=1;//объявляем индекс цикла
    foreach($spisok_zakazov as $ocherednoy_zakaz){
        echo'<tr>';

            echo'<td class="tekst_po_centru yacheyka_tablitsi_zakazi">';
            echo $i.') ';
            echo'</td>';

            echo'<td class="tekst_po_centru yacheyka_tablitsi_zakazi">';
            echo '#'.$ocherednoy_zakaz['nomer_zakaza'];
            echo'</td>';

            echo'<td class="tekst_po_centru yacheyka_tablitsi_zakazi">';
            echo $ocherednoy_zakaz['data_zakaza'];
            echo'</td>';

            echo'<td class="yacheyka_tablitsi_zakazi">';
            echo $ocherednoy_zakaz['naimenovanie_pokupatelya'];
            echo'</td>';

            echo'<td class="tekst_po_centru yacheyka_tablitsi_zakazi">';
            echo $ocherednoy_zakaz['summa_zakaza'].' грн';
            echo'</td>';

            echo'<td class="tekst_po_centru yacheyka_tablitsi_zakazi">';
            echo $ocherednoy_zakaz['status_zakaza'];
            echo'</td>';

            echo'<td class="yacheyka_tablitsi_zakazi">';
            echo '<input type="button" value="Посмотреть заказ" onclick="posmotret_zakaz('.$ocherednoy_zakaz['nomer_zakaza'].');">';
            echo '<input type="button" value="Изменить статус" onclick="otobrazit_formu_redaktirovamiya_statusa_zakaza('.$ocherednoy_zakaz['nomer_zakaza'].');">';
            echo'</td>';

        echo'</tr>';
        $i++;
    }

    echo '</table>';
} else echo 'Таких заказов нет';