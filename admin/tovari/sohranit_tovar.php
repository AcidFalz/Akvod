<?php
/* Вспомагательный скрипт для сохранения в БД изменений о товаре
Получает данные через GET. deystvie: sohranit | sozdat

    var zapros="/admin/tovari/sohrahin_tovar.php?id_tovara="
                +Forma.id_tovara.value
                +"&nazvanie_tovara="
                +Forma.nazvanie_tovara.value
                +"&link_na_small_kartinku="
                +Forma.link_na_small_kartinku.value
                +"&tsena="
                +Forma.tsena.value
                +"&nalichie_na_sklade="
                +Forma.nalichie_na_sklade.value
                +"&opisanie_tovara="
                +Forma.opisanie_tovara.value
                +"&deystvie="+deystvie;

*/

//Подключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли

$query="";
//Формируем запрос
if($_GET['deystvie']=='sohranit'){
    $query="UPDATE `Tovari_table`
            SET `nazvanie_tovara`='".mysql_real_escape_string($_GET['nazvanie_tovara'])."',
                `link_na_small_kartinku`='".mysql_real_escape_string($_GET['link_na_small_kartinku'])."',
                `tsena`=".mysql_real_escape_string($_GET['tsena']).",
                `nalichie_na_sklade`=".mysql_real_escape_string($_GET['nalichie_na_sklade']).",
                `opisanie_tovara`='".mysql_real_escape_string($_GET['opisanie_tovara'])."'
            WHERE `id_tovara`=".mysql_real_escape_string($_GET['id_tovara'])."";

}
elseif($_GET['deystvie']=='sozdat'){
    $query="INSERT INTO `Tovari_table`
                (`nazvanie_tovara`,
                 `link_na_small_kartinku`,
                 `tsena`,
                 `nalichie_na_sklade`,
                 `opisanie_tovara`)
             VALUES
                ('".mysql_real_escape_string($_GET['nazvanie_tovara'])."',
                 '".mysql_real_escape_string($_GET['link_na_small_kartinku'])."',
                 ".mysql_real_escape_string($_GET['tsena']).",
                 ".mysql_real_escape_string($_GET['nalichie_na_sklade']).",
                 '".mysql_real_escape_string($_GET['opisanie_tovara'])."')";

}

$rezult=mysql_query($query);
if(!$rezult){
    echo 'Ошибка сохранения товара<br>'.mysql_error();
    echo '<input type="button"
                 value="Закрыть"
                 onclick="document.getElementById(\'vsplivayuschee_okno\').style.display=\'none\'">';
    echo('<br>');
    echo $query;
    exit;
}

