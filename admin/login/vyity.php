<?php
/* Вспомагательный скрипт для завершения сеанса работы админа на странице администратора */


//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);


//Инициируем сессию
session_start();



//ВОТ ОНИ: СТРОКИ РАЗЛОГИНИВАНИЯ ПОЛЬЗОВАТЕЛЯ
unset($_SESSION['dannie_o_admine']);
unset($_SESSION['id_admina']);
unset($_SESSION['imya_admina']);
unset($_SESSION['e-mail']);


echo '<script language="JavaScript">document.location.href="/admin/"</script>';

