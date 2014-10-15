<?php
/**Скрипт внесения изменений в данные о пользователе в базу*/

/* Читает переменные:
$_POST['naimenovanie_pokupatelya']
$_POST['telephon']
$_POST['id_pokupatelya']

Пишет переменные:
$_GET['rezultat_izmeneniya']

*/

//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);


//СТартуем сессию
session_start();


//Если переданные данные не пусты, то вносим данные в базу
if(isset($_POST['naimenovanie_pokupatelya']) and isset($_POST['telephon'])){

    //  1) Устанавливаем соединение с БД
    include ("../db/db_connect.php");//подключаем файл с параметрами соединения
    $connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
    if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
    $db_select=mysql_select_db($db_database);//выбираем БД
    if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


        $naimenovanie_pokupatelya=mysql_real_escape_string($_POST['naimenovanie_pokupatelya']);
        $telephon=mysql_real_escape_string($_POST['telephon']);

        $query= "UPDATE
                    `Pokupateli_table`
                 SET";
        $query.= "`telephon` =";
        $query.="'".$_POST['telephon']."',";
        $query.="`naimenovanie_pokupatelya`=";
        $query.="'".$_POST['naimenovanie_pokupatelya']."'";
        $query.="WHERE
                 `id_pokupatelya` = ";
        $query.=$_POST['id_pokupatelya'];
        //$query.=";";


        $result=mysql_query($query); //изменяем запись о пользователе в базе
        if(!$result){echo ('Ошибка изменения записи о ПОКУПАТЕЛЕ<br />'.mysql_error()).'<br>';}//проверяем изменились ли

        if($result) {
            $_SESSION['naimenovanie_pokupatelya']=$_POST['naimenovanie_pokupatelya'];
            $_SESSION['dannie_o_polzovatele']['telephon']=$_POST['telephon'];

            echo '<script language="JavaScript">
                        document.location.href="/lichniy_kabinet/index.php?rezultat_izmeneniya=Данные успешно изменены"
                  </script>';
        }else{
            echo '<script language="JavaScript">
                        alert("Ошибка внесения изменений");
                        document.location.href="/lichniy_kabinet/index.php?rezultat_izmeneniya=Ошибка внесения изменений"
                  </script>';
        }

}else {
    echo '<script language="JavaScript">
                       document.location.href="/lichniy_kabinet/"
                 </script>';
}


?>
