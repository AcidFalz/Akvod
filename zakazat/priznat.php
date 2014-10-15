<?php
/*Скрипт авторизации существующего пользователя
 */

/* Читает переменные:
$_POST['login']
$_POST['parol']
$_POST['otsovskaya_stranitsa']  - Ссылка на скрипт-заказчика авторизации

Записывает переменные:
$_GET['oshinka_avtorizatsii']   - Флаг ошибка авторизации (выставляется при неверном логине/пароле)
$_SESSION['dannie_o_polzovatele']
           $dannie_o_polzovatele = array (
                    `id_pokupatelya`,
                    `naimenovanie_pokupatelya`,
                    `telephon`,
                    `email_via_login`,
                    `data_registratsii`
                     )
$_SESSION['id_pokupatelya']
$_SESSION['naimenovanie_pokupatelya']
$_SESSION['email_via_login']




Логика скрипта:
1)	Получить через POST ссылку на скрип-заявителя (otsovskaya_stranitsa)
Если нет сессии, инициировать сессию.
2)	Получить через POST логин и пароль
3)
Если логин или пароль пусты, то
передать через $_GET['oshinka_avtorizatsii']=Ни логин ни пароль не могут буть пустыми,
вызвать отцовскую страницу,
и прервать выполнение скрипта.

Если
логин или пароль НЕ пусты, то
Установить связь с БД
Сформировать и выполнить запрос к БД

Дальше
Если
в БД есть такой пользователь, то
присвоить переменной сессии “id_pokupatelya” id-покупателя,
naimenovanie_pokupatelya, email_via_login
очистить oshinka_avtorizatsii
вызвать скрипт заявителя “otsovskaya_stranitsa”

иначе
передать через $_GET['oshinka_avtorizatsii']=Неверный логин или пароль,
вызвать отцовскую страницу,
и прервать выполнение скрипта.

 */



//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);


//Инициируем сессию
session_start();


// Получаем отцовскую страницу
if(isset($_POST['otsovskaya_stranitsa'])){
$otsovskaya_stranitsa=$_POST['otsovskaya_stranitsa'];
$otsovskaya_stranitsa = addslashes($otsovskaya_stranitsa);
}else {$otsovskaya_stranitsa='/zakazat/index.php';}


//Если логин или пароль пусты, то записываем ошибку, вызываем отцовскую сраницу и прерываем скрипт
If(empty($_POST['login']) or empty($_POST['parol'])){
    echo '<script language="JavaScript">
            document.location.href="'.$otsovskaya_stranitsa.'?oshinka_avtorizatsii=Ни логин ни пароль не могут буть пустыми"
          </script>';
    exit;
}


//Если логин и пароль не пусты, то сформировать и выполнить запрос к БД
if(isset($_POST['login']) and isset($_POST['parol'])){

    //УСТАНАВЛИВАЕМ СОЕДИНЕНИЕ С БАЗОЙ,
    include ("../db/db_connect.php");//подключаем файл с параметрами соединения
    $connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
    if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
    $db_select=mysql_select_db($db_database);//выбираем БД
    if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


    $login=mysql_real_escape_string($_POST['login']);
    $parol=mysql_real_escape_string($_POST['parol']);

    //ФОРМИРУЕМ И ВЫПОЛНЯЕМ ЗАПРОС
    $query = 'SELECT
                `id_pokupatelya`,
                `naimenovanie_pokupatelya`,
                `telephon`,
                `email_via_login`,
                `data_registratsii`
                FROM `Pokupateli_table`
                WHERE
                    `email_via_login`="'.$login.'"
                    and
                    `parol_k_uchetnoi_zapisi`="'.$parol.'";';//составить запрос данных о пользователе

    $result=mysql_query($query);//выполнить запрос
    if(!$result){echo ('Ошибка выборки данных о пользователе<br />'.mysql_error());}//проверяем выбрались ли

    //ЗАВЕРШАЕМ СОЕДИНЕНИЕ С БД
    mysql_close($connection);



    //Если в базе есть такой пользователь, то заполнить переменные сессии и вызвать отцовскую страницу
    if(mysql_num_rows($result)>0){

        $dannie_o_polzovatele=mysql_fetch_array($result, MYSQL_ASSOC);
        /*Массив имеет такие поля
        array $dannie_o_polzovatele(
                `id_pokupatelya`,
                `naimenovanie_pokupatelya`,
                `telephon`,
                `email_via_login`,
                `data_registratsii`
                 )
        */

        //ВОТ ОНИ: СТРОКИ ПРИЗНАВАНИЯ ПОЛЬЗОВАТЕЛЯ
        $_SESSION['dannie_o_polzovatele']=$dannie_o_polzovatele;
        $_SESSION['id_pokupatelya']=$dannie_o_polzovatele['id_pokupatelya'];
        $_SESSION['naimenovanie_pokupatelya']=$dannie_o_polzovatele['naimenovanie_pokupatelya'];
        $_SESSION['email_via_login']=$dannie_o_polzovatele['email_via_login'];


        echo '<script language="JavaScript">document.location.href="'.$otsovskaya_stranitsa.'"</script>';
        exit;

    }else {
        echo '<script language="JavaScript">
                document.location.href="'.$otsovskaya_stranitsa.'?oshinka_avtorizatsii=Неверный логин или пароль"
              </script>';
        exit;
    }




}//Если логин и пароль не пусты, то сформировать и выполнить запрос к БД



?>