<?php

/* Страница авторизации админа

    1) Проверяем залогинен ли какой либо админ?
    2) Если админ залогинен, то переправляем на титульную страницу админ-части
    3) Если не залогинен, то отображаем Стараницу с формой авторизации.
       Форма вызывает скрипт проверки введенного пароля и авторизации админа.

*/



//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);


//Стартуем сессию
session_start();


//Проверяем залогинен ли?
    /*Если не залогинен, то переправляем на скрипт авторизации
    и прекращаем выполнения скрипта
    */
if(isset($_SESSION['id_admina'])){
    echo '<script language="JavaScript">document.location.href="/admin/"</script>';
    exit;
}


//Отображаем шапку
echo '<!DOCTYPE html>
<html>
<head>
    <title>АКВОД Админ Авторизация</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/admin/css/admin.css" media="all">
    <link rel="shortcut icon" href="/img/favicon.png" type="image/png">

</head>
<body>';



//Отображаем форму ввода пароля
echo '
    <form action="/admin/login/priznat.php" method="post" id="forma_avtorizatsii">

        <table id="tablitsa_formi_avtorizatsii">
            <caption>    <ul><strong>Вход в АКВОД-Админ</strong></ul>
            Введите логин и пароль администратора</caption>

            <tr>
                <td>Логин</td>
                <td><input title="Логин" name="login" type="text"></td>
            </tr>
            <tr>
                <td>Пароль</td>
                <td><input title="Пароль" name="parol" type="password"></td>
            </tr>';

if(isset($_GET['oshinka_avtorizatsii'])){
                echo '
                
                <tr><td colspan="2">'.$_GET['oshinka_avtorizatsii'].'</td></tr>

                ';
            }

echo       '<tr>
                <td colspan="2"><input type="submit" value="Войти"  id="knopka_voyti"></td>
            </tr>

        </table>
    </form>
      ';





//Отображаем подвал
echo '
</body>
</html>';