<?php
/* Вспомагательный скрипт для сохранения в БД изменений о новости
Получает данные через GET. deystvie: sohranit | sozdat

    var zapros="/admin/novosti/sohranit_novoct.php?id_novosti=";
            if(deystvie == "sohranit") zapros+=Forma.id_novosti.value;
            zapros+="&data_vihoda_novosti="
                            +Forma.data_vihoda_novosti.value
                            +"&nazvanie_novosti="
                            +Forma.nazvanie_novosti.value
                            +"&anons_of_a_new="
                            +Forma.anons_of_a_new.value
                            +"&path_to_a_new="
                            +Forma.path_to_a_new.value
                            +"&miniatyura_img="
                            +Forma.miniatyura_img.value
                            +"&opublikovana="
                            +Forma.opublikovana.value
                            +"&deystvie="+deystvie
                            +"&razoslat="
                            +Forma.razoslat.checked;

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
    $query="UPDATE `Novosti_table`
            SET `data_vihoda_novosti`='".mysql_real_escape_string($_GET['data_vihoda_novosti'])."',
                `nazvanie_novosti`='".mysql_real_escape_string($_GET['nazvanie_novosti'])."',
                `anons_of_a_new`='".mysql_real_escape_string($_GET['anons_of_a_new'])."',
                `path_to_a_new`='".mysql_real_escape_string($_GET['path_to_a_new'])."',
                `miniatyura_img`='".mysql_real_escape_string($_GET['miniatyura_img'])."',
                `opublikovana`=".mysql_real_escape_string($_GET['opublikovana'])."
            WHERE `id_novosti`=".mysql_real_escape_string($_GET['id_novosti'])."";

}elseif($_GET['deystvie']=='sozdat'){
    $query="INSERT INTO `Novosti_table`
                (`data_vihoda_novosti`,
                 `nazvanie_novosti`,
                 `anons_of_a_new`,
                 `path_to_a_new`,
                 `miniatyura_img`,
                 `opublikovana`)
             VALUES
                ('".mysql_real_escape_string($_GET['data_vihoda_novosti'])."',
                 '".mysql_real_escape_string($_GET['nazvanie_novosti'])."',
                 '".mysql_real_escape_string($_GET['anons_of_a_new'])."',
                 '".mysql_real_escape_string($_GET['path_to_a_new'])."',
                 '".mysql_real_escape_string($_GET['miniatyura_img'])."',
                 ".mysql_real_escape_string($_GET['opublikovana']).")";

}


//Выполняем запрос
$rezult=mysql_query($query);


//Проверяем результат выполнения запроса
if(!$rezult){
    echo $query.'<br>';
    echo 'Ошибка сохранения новости<br>'.mysql_error();
    echo '<input type="button"
                 value="Закрыть"
                 onclick="document.getElementById(\'vsplivayuschee_okno\').style.display=\'none\'">';
    exit;
}

mysql_close();

if($_GET['razoslat']=='true'){
   include "razoslat_po_spisku_rassylki.php";

}
