<?php
/*
 * Скрипт вызывается через XMLHttpRequest из истории заказов в личном кабинете.
 * Результатом работы скрипта есть таблица содержащая состав указанного заказа указанного пользователя.
 * Скрипт получает номер заказа и имя польщователя через GET.
 */

/* Получаемые переменные:
GET['u'] -- имя пользователя
GET['z'] -- номер заказа
*/


//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);



//Инициируем сессию
session_start();



/*
2)	Проверяем авторизирован ли пользователь,
Если ДА, то устанавливаем флаг “zalogonen”=YES,
Иначе устанавливаем флаг “zalogonen”=NO.
 */

if(isset($_SESSION['id_pokupatelya'])){
    $zaloginen = 1;
}
else{
    $zaloginen = 0;
}





if($zaloginen){
    //УСТАНАВЛИВАЕМ СОЕДИНЕНИЕ С БАЗОЙ,

    include ("../db/db_connect.php");//подключаем файл с параметрами соединения
    $connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
    if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
    $db_select=mysql_select_db($db_database);//выбираем БД
    if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли



    //ФОРМИРУЕМ И ВЫПОЛНЯЕМ НЕОБХОДИМЫЕ ЗАПРОСЫ

    //Перечень заказов и даные о них
    /* выбираем: номер заказа, дату заказа, сумму заказа, состояние заказа
    */
    $id_zakaza = mysql_real_escape_string($_GET['z']);
    $query = "SELECT t1.`nazvanie_tovara`,\n
        	t2.`kolichestvo_shtuk_tovara_v_zakaze`,\n
            t1.`tsena`,\n
            t2.`kolichestvo_shtuk_tovara_v_zakaze`*t1.`tsena` as summa \n

        FROM `Tovari_table` as t1\n
        JOIN `Sostav_zakaza_table` as t2 on t1.`id_tovara`=t2.`id_tovara`\n
        WHERE t2.`id_zakaza`=";
    $query .= $id_zakaza;

    $result=mysql_query($query);//выполнить запрос
    if(!$result){echo ('Ошибка выборки данных о заказе<br />'.mysql_error()); exit;}//проверяем выбрался ли


    //Преобразуем полученные из БД данные в массив
    $kolichestvo_tovarov_v_zakzaze=mysql_num_rows($result);
    for($i=0;$i<$kolichestvo_tovarov_v_zakzaze;$i++){
        $sostav_zakaza_massiv[]=mysql_fetch_array($result, MYSQL_ASSOC);
    }

    /*В массиве имеем такие поля
         $sostav_zakaza_massiv[0] = array (
                'nazvanie_tovara',
                'kolichestvo_shtuk_tovara_v_zakaze',
                'tsena',
                'summa',
                'id_zakaza'
                )

    */


    //Детали заказа
    /* выбираем:    способ доставки,
                    адрес доставки,
                    способ оплаты,
                    статус заказа,
                    примечание к заказу,
                    дату заказа,*/
    $query = 'SELECT    t1.`naimenovanie_sposoba_dostavki` as `sposob_dostavki`,
                        t4.`adress_dostavki`,
                        t2.`naimenovanie_sposoba_oplati` as `sposob_oplati`,
                        t3.`naimenovanie_statusa` as `status_zakaza`,
                        t4.`primechanie_k_zakazu`,
                        t4.`data_zakaza`

               FROM `Zakazi_table` as t4

                JOIN `Sposobi_dostavki_table` as t1 on t1.`id_sposoba_dostavki` = t4.`id_sposoba_dostavki`
                JOIN `Sposobi_oplati_table` as t2 on t2.`id_sposoba_oplati` = t4.`id_sposoba_oplati`
                JOIN `Vozmozhnie_statusi_zakaza_table` as t3 on t3.`id_statusa` = t4.`id_statusa_zakaza`

              WHERE `id_zakaza` = ';
    $query .= $id_zakaza;

    $result=mysql_query($query);//выполнить запрос
    if(!$result){echo ('Ошибка выборки деталей заказа<br />'.mysql_error()); exit;}//проверяем выбрался ли

    $detali_zakaza = mysql_fetch_array($result, MYSQL_ASSOC);
    /* Получился массив
         $detali_zakaza = array (
                    `sposob_dostavki`,
                    `adress_dostavki`,
                    `sposob_oplati`,
                    `status_zakaza`,
                    `primechanie_k_zakazu`,
                    `data_zakaza`
                        );
        */



    mysql_close($connection);




    //Состав заказа выводим в виде таблицы
    echo '<table>';
    echo '<caption><strong>СОСТАВ ЗАКАЗА №'.$id_zakaza.' от '.$detali_zakaza['data_zakaza'].'</strong></caption>';
    echo '<tr>'; //Строка заголовков
    echo    '<td></td>';
    echo    '<td>Название товара</td>';
    echo    '<td>Кол</td>';
    echo    '<td>Цена</td>';
    echo    '<td class="tekst_po_centru">Сумма</td>';
    echo '</tr>';//Конец строки заголовков


    //В цикле построчно выводим состав заказа
    $nomer_v_spiske=0;
    $summa_zakaza = 0;
    foreach($sostav_zakaza_massiv as $ocherednoy_tovar_v_zakaze){
        $nomer_v_spiske++;
        echo '<tr>';
        echo    '<td class="yacheyka_tablitsi_zakazi tekst_po_centru">'.$nomer_v_spiske.')</td>';
        echo    '<td class="yacheyka_tablitsi_zakazi">'.$ocherednoy_tovar_v_zakaze['nazvanie_tovara'].'</td>';
        echo    '<td class="yacheyka_tablitsi_zakazi tekst_po_centru">'.$ocherednoy_tovar_v_zakaze['kolichestvo_shtuk_tovara_v_zakaze'].' уп</td>';
        echo    '<td class="yacheyka_tablitsi_zakazi tekst_po_centru">'.$ocherednoy_tovar_v_zakaze['tsena'].' грн/уп</td>';
        echo    '<td class="yacheyka_tablitsi_zakazi tekst_po_centru">'.$ocherednoy_tovar_v_zakaze['summa'].' грн</td>';
        echo '</tr>';
        $summa_zakaza += $ocherednoy_tovar_v_zakaze['summa'];
    }
    echo '<tr><td></td><td></td><td></td><td class="tekst_po_centru">Всего:</td><td>';
    echo $summa_zakaza.' грн с НДС';
    echo '</td></tr>';
    echo '</table>';

//Далее выводим детали заказа
    echo '<hr>';
    echo '<ul class="tekst_sleva">Способ доставки: <strong>'.$detali_zakaza['sposob_dostavki'].'</strong></ul>';
    echo '<ul class="tekst_sleva">Адрес доставки: <strong>'.$detali_zakaza['adress_dostavki'].'</strong></ul>';
    echo '<ul class="tekst_sleva">Способ оплаты: <strong>'.$detali_zakaza['sposob_oplati'].'</strong></ul>';
    echo '<ul class="tekst_sleva">Статус заказа: <strong>'.$detali_zakaza['status_zakaza'].'</strong></ul>';
    echo '<ul class="tekst_sleva">Примечание: <strong>'.$detali_zakaza['primechanie_k_zakazu'].'</strong></ul>';





} else {
    echo 'Чтобы получить информацию о заказе, неоходимо залогиниться';
}