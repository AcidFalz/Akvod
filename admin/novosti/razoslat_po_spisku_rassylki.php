<?php
/* Вспомагательный скрипт включаемый в скрипт сохранения новости для групповой отправки новостной рассылки.
Выбирает из БД перечень е-мэйлов, включенных в рассылку и отправляет на них письмо с последней новостью*/

//Подключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли

//Формируем и выполняем запрос
$query="SELECT * FROM `Podpischiki_na_novosti_table`";

$rezult=mysql_query($query);

if(!$rezult){echo 'Ошибка выборки списка подписчиков'.mysql_error(); exit;}


//Сохраняем перечень подписчиков в массиве
$kolichestvo_podpischikov = mysql_num_rows($rezult);
for($i=0;$i<$kolichestvo_podpischikov;$i++){
    $podpischiki[]=mysql_fetch_array($rezult, MYSQL_ASSOC);
}





//Обходим массив и для каждых трех адресатов отправляем письмо с рассылкой
foreach($podpischiki as $ocherednoy_podpischik) {
    $por[]=$ocherednoy_podpischik['e-mail_podpischika'];
    if(count($por)==3){
        otpravit($por); //Это такая моя функция, которая получает массив из адресатов и отправляет их новость
        $por="";
    }
}
otpravit($por);





//Собственно функция отправки посьма с новостью
function otpravit($portsiya){

    //Определяем получателей
    $to=implode(", ", $portsiya);

    //Формируем заголовок
    $headers="From: AKVOD <akvod@ukr.net>\nReply-to:akvod@ukr.net\nContent-Type:text/html; charset=\"utf-8\"\n";

    //Заполняем тему письма
    $tema = $_GET['nazvanie_novosti'];

    //Составляем письмо
    $tekst_pisma=wordwrap($_GET['anons_of_a_new'], 70);

    //ОТПРАВЛЯЕМ ПИСЬМО
    if(!mail($to, $tema, $tekst_pisma, $headers))echo 'Ошибка отправки новости почтой на '.$to;

}
