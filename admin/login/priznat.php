<?php
/*скрипт проверки введенного пароля и авторизации админа
*/

/* Читает переменные:
$_POST['login']
$_POST['parol']

Записывает переменные:
$_GET['oshinka_avtorizatsii']   - Флаг ошибка авторизации (выставляется при неверном логине/пароле)
$_SESSION['id_admina']
$_SESSION['imya_admina']
$_SESSION['e-mail']
$_SESSION['telephon']
$_SESSION['uvedomlyat_na_telephon']
$_SESSION['uvedomlyat_na_email']
*/


//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);


//Инициируем сессию
session_start();


//Если логин или пароль пусты, то записываем ошибку, вызываем отцовскую сраницу и прерываем скрипт
If(empty($_POST['login']) or empty($_POST['parol'])){
    echo '<script language="JavaScript">
            document.location.href="/admin/login/zayti.php?oshinka_avtorizatsii=Ни логин ни пароль не могут буть пустыми";
          </script>';
    exit;
}




//Если логин и пароль не пусты, то сформировать и выполнить запрос к БД
if(isset($_POST['login']) and isset($_POST['parol'])){

    //УСТАНАВЛИВАЕМ СОЕДИНЕНИЕ С БАЗОЙ,
    include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
    $connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
    if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
    $db_select=mysql_select_db($db_database);//выбираем БД
    if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


    $login=mysql_real_escape_string($_POST['login']);
    $parol=mysql_real_escape_string($_POST['parol']);

    //ФОРМИРУЕМ И ВЫПОЛНЯЕМ ЗАПРОС
    $query = 'SELECT *
              FROM `Administratori_table`
              WHERE
                    `login`="'.$login.'"
                    and
                    `parol`=MD5("'.$parol.'")';//составить запрос данных о пользователе

    $result=mysql_query($query);//выполнить запрос
    if(!$result){echo ('Ошибка выборки данных о пользователе<br />'.mysql_error());}//проверяем выбрались ли

    //ЗАВЕРШАЕМ СОЕДИНЕНИЕ С БД
    mysql_close($connection);



    //Если в базе есть такой пользователь, то заполнить переменные сессии и вызвать отцовскую страницу
    if(mysql_num_rows($result)>0){

        $dannie_o_admine=mysql_fetch_array($result, MYSQL_ASSOC);
        /*Массив имеет такие поля
        array $dannie_o_admine(
                `id_admina`,
                `imya_admina`,
                `login`,
                `parol`,
                `e-mail`
                `telephon`
                `uvedomlyat_na_telephon`
                `uvedomlyat_na_email`
                 )
        */

        //ВОТ ОНИ: СТРОКИ ПРИЗНАВАНИЯ ПОЛЬЗОВАТЕЛЯ
        $_SESSION['dannie_o_admine']=$dannie_o_admine;
        $_SESSION['id_admina']=$dannie_o_admine['id_admina'];
        $_SESSION['imya_admina']=$dannie_o_admine['imya_admina'];
        $_SESSION['e-mail']=$dannie_o_admine['e-mail'];


        echo '<script language="JavaScript">document.location.href="/admin/login/zayti.php"</script>';
        exit;

    }else {
        echo '<script language="JavaScript">
                document.location.href="/admin/login/zayti.php?oshinka_avtorizatsii=Неверный логин или пароль"
              </script>';
        exit;
    }




}//Если логин и пароль не пусты, то сформировать и выполнить запрос к БД

