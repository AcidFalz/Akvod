<?php
/* Вспомагательный скрипт для удаления записи из корзины
*/

/*
Логика скрипта
1)	Получить через GET единственный параметр: номер позиции товара в массиве корзины
2)	Удалить эту запись из массива
3)	Вызвать скрипт zakazat/index.php

*/


//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);


//стартуем сессию
session_start();


//получаем через переменную сессии содержимое корзины
$korzina=$_SESSION['korzina'];


//получем через GET номер позиции товара в массиве корзины, который нужно удалить
$nomer_pozitsii_dlya_udalenia=$_GET['n'];

//удаляем из корзины требуемый товар
unset($korzina[$nomer_pozitsii_dlya_udalenia]);

//сохраняем получвшееся содержимое корзины в переменной сессии
$_SESSION['korzina']=$korzina;


//Получаем ссылку на родительскую форму
$s=$_GET['s'];

//Определяем родительскую форму
switch ($s){
    case 1: $ssilka='index.php';break;
    case 2: $ssilka='oformit.php';break;
}



//вызываем скрип родительский zakazat/index.php
echo '<script language="JavaScript">document.location.href="'.$ssilka.'"</script>';





?>