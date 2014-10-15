<?php
/*Скрипт разлогинивания
 */



//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);


//Инициируем сессию
session_start();


// Получаем отцовскую страницу
if(isset($_GET['otsovskaya_stranitsa']))
    {
    $otsovskaya_stranitsa=$_GET['otsovskaya_stranitsa'];
    }

    else{$otsovskaya_stranitsa='/zakazat/index.php';}



//ВОТ ОНИ: СТРОКИ РАЗЛОГИНИВАНИЯ ПОЛЬЗОВАТЕЛЯ
unset($_SESSION['id_pokupatelya']);
unset($_SESSION['naimenovanie_pokupatelya']);
unset($_SESSION['email_via_login']);


echo '<script language="JavaScript">document.location.href="'.$otsovskaya_stranitsa.'"</script>';


?>