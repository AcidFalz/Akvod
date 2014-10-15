<?php
/*Это форма ОТЧЕТ ОБРАБОТКИ ЗАКАЗА
СОхраняет принятый заказ в базе и выдает сообщение о успешном принятии заказа.
Данные для сохранения получаем из формы oformit.php через POST
в таких полях:

    $_POST['sposob_dostavki']
    $_POST['sposob_oplati']
    $_POST['naimenovanie_pokupatelya']
    $_POST['telephon']
    $_POST['adress_dostavki']
    $_POST['primechanie_k_zakazu']


1)  Проверяем через сессию, залогинен ли пользователь
2)  Если пользователь не залогинен и нет необходимости создавать учетную запись,
    то формируем простой запрос и вносим в БД данные о новом пользователе.

*/


//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);



// стартуем сессию
session_start();


/* Проверяем авторизирован ли пользователь,
Если ДА, то устанавливаем флаг “zalogonen”=YES,
Иначе устанавливаем флаг “zalogonen”=NO.

Когда пользователь залогинен, то в переменных сессии есть такие данные:
$_SESSION['id_pokupatelya']
$_SESSION['naimenovanie_pokupatelya']
$_SESSION['email_via_login']
 */

if(isset($_SESSION['id_pokupatelya'])){
    $zaloginen = 1;
}
else{
    $zaloginen = 0;
}



//Получаем содержимое КОРЗИНЫ
$korzina=$_SESSION['korzina'];

/* Массив Корзины содержит следующие поля
$korzina[] = array(
    'id_tovara' => $_POST['id_tovara'],
    'nazvanie_tovara' => $_POST['nazvanie_tovara'],
    'tsena' => $_POST['tsena'],
    'kolichestvo_shtuk_v_zakaze' => $_POST['kolichestvo_shtuk_v_zakaze']

    );
*/

/* Массив $Данные_о_пользователе_и_его_заказе содержит следующие поля

$danie_o_polzovatele_i_ego_zakaze=array(
        "sposob_dostavki" => $_POST["sposob_dostavki"],
        "sposob_oplati" => $_POST["sposob_oplati"],
        "naimenovanie_pokupatelya" => $_POST["naimenovanie_pokupatelya"],
        "telephon" => $_POST["telephon"],
        "adress_dostavki" => $_POST["adress_dostavki"],
        "primechanie_k_zakazu" => $_POST["primechanie_k_zakazu"]
        );

*/

//Сохраняем в массиве переменной сесии введенные данные о пользователе и его заказе
if(!isset($_SESSION['danie_o_polzovatele_i_ego_zakaze'])){

    $danie_o_polzovatele_i_ego_zakaze=array(
        "sposob_dostavki" => $_POST["sposob_dostavki"],
        "sposob_oplati" => $_POST["sposob_oplati"],
        "naimenovanie_pokupatelya" => $_POST["naimenovanie_pokupatelya"],
        "telephon" => $_POST["telephon"],
        "adress_dostavki" => $_POST["adress_dostavki"],
        "primechanie_k_zakazu" => $_POST["primechanie_k_zakazu"]
        );

    $_SESSION['danie_o_polzovatele_i_ego_zakaze']=$danie_o_polzovatele_i_ego_zakaze;

} else {$danie_o_polzovatele_i_ego_zakaze=$_SESSION['danie_o_polzovatele_i_ego_zakaze'];}



//  1) Устанавливаем соединение с БД
include ("../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли





/*  2) Вносим в БД запись о новом незарегистрированном покупателе в таблицу ПОКУПАТЕЛИ, если не залогинен сущ.пользователь
     иначе берем id_pokupatelya */
if(!$zaloginen){
   if(!empty($_SESSION['email_via_login']) and !empty($_SESSION['parol'])) { //Если есть е-мэйл и пароль, то составляем полный запрос
    $sql = '
    INSERT INTO `Pokupateli_table`
        (`id_pokupatelya`,
         `naimenovanie_pokupatelya`,
         `telephon`,
         `email_via_login`,
         `parol_k_uchetnoi_zapisi`,
         `data_registratsii`)
      VALUES
        (NULL,
         \''.mysql_real_escape_string($danie_o_polzovatele_i_ego_zakaze['naimenovanie_pokupatelya']).'\',
         \''.mysql_real_escape_string($danie_o_polzovatele_i_ego_zakaze['telephon']).'\',
         \''.mysql_real_escape_string($_SESSION['email_via_login']).'\',
         \''.mysql_real_escape_string($_SESSION['parol']).'\',
         now());
        ';

       //Ставим флаг, что создана учетная запись
       $sozdana_uchetnaya_zapis=true;

   } else {
       $sql = '
           INSERT INTO `Pokupateli_table`
               (`id_pokupatelya`,
                `naimenovanie_pokupatelya`,
                `telephon`,
                `data_registratsii`)
             VALUES
               (NULL,
                \''.mysql_real_escape_string($danie_o_polzovatele_i_ego_zakaze['naimenovanie_pokupatelya']).'\',
                \''.mysql_real_escape_string($danie_o_polzovatele_i_ego_zakaze['telephon']).'\',
                now());
               ';
   }

    $result=mysql_query($sql); //вносим запись о пользователе в таблицу
    if(!$result){echo ('Ошибка вставки записи о новом ПОКУПАТЕЛЕ<br />'.mysql_error()).'<br>';exit;}//проверяем внеслась ли

    $id_pokupatelya_dlya_zaprosa=mysql_insert_id($connection); //Получаем ID последнего добавленного пользователя

}else $id_pokupatelya_dlya_zaprosa=$_SESSION['id_pokupatelya'];



//  3) Вносим в БД запись о новом заказе в таблицу ЗАКАЗЫ


    $sql = '
    INSERT INTO `Zakazi_table`
        (`id_zakaza`,
         `id_pokupatelya`,
         `id_sposoba_dostavki`,
         `adress_dostavki`,
         `id_sposoba_oplati`,
         `id_statusa_zakaza`,
         `primechanie_k_zakazu`,
         `data_zakaza`)
       VALUES
         (NULL,
         '.$id_pokupatelya_dlya_zaprosa.',
         '.mysql_real_escape_string($danie_o_polzovatele_i_ego_zakaze["sposob_dostavki"]).',
         \''.mysql_real_escape_string($danie_o_polzovatele_i_ego_zakaze["adress_dostavki"]).'\',
         '.mysql_real_escape_string($danie_o_polzovatele_i_ego_zakaze["sposob_oplati"]).',
         1,
         \''.mysql_real_escape_string($danie_o_polzovatele_i_ego_zakaze["primechanie_k_zakazu"]).'\',
         now());
         ';


$result=mysql_query($sql); //вносим запись о новом заказе в таблицу
if(!$result){echo ($sql.'<br>Ошибка вставки записи о новом ЗАКАЗЕ<br />'.mysql_error()).'<br>';exit;}//проверяем внеслась ли

$id_zakaza_last_added=mysql_insert_id($connection); //Получаем ID последнего добавленного заказа





//  4) Вносим в БД запись о составе заказа в таблицу СОСТАВ ЗАКАЗА

foreach ($korzina as $pozitsiya_v_zakaze => $tovar_v_korzine) {
    $sql='
        INSERT INTO `Sostav_zakaza_table`
            (`id_zapisi_sostava`,
            `id_zakaza`,
            `id_tovara`,
            `kolichestvo_shtuk_tovara_v_zakaze`)
            VALUES
                (NULL,
                \''.$id_zakaza_last_added.'\',
                \''.mysql_real_escape_string($tovar_v_korzine['id_tovara']).'\',
                \''.mysql_real_escape_string($tovar_v_korzine['kolichestvo_shtuk_v_zakaze']).'\');
          ';


$result=mysql_query($sql); //вносим запись о товаре в заказе в таблицу
if(!$result){echo ('Ошибка вставки записи в СОСТАВ ЗАКАЗА<br />'.mysql_error()).'<br>';exit;}//проверяем внеслась ли

}







//Отправляется письмо покупателю с информацией о заказе
//Если создана учетная запись, то в письмо Покупателю вставляются данные о учетной записи
//В тексте письма используются $_SESSION['email_via_login'] и $_SESSION['parol']

if((isset($sozdana_uchetnaya_zapis) and $sozdana_uchetnaya_zapis) or $zaloginen){
    $headers="From: AKVOD <akvod@ukr.net>\nReply-to:akvod@ukr.ne\nContent-Type:text/html; charset=\"utf-8\"\n";
    $e_mail=$_SESSION['email_via_login'];

    $text_pisma='Здравствуйте,<br>';
    $text_pisma.='Ваш заказ успешно принят. В течение суток с Вами свяжется наш менеджер для уточнения деталей.<br>';
    $text_pisma.='Номер вашего заказа: <strong>'.$id_zakaza_last_added.'</strong>.<br>';
    $text_pisma.='Посмотрите свой заказ в <a href="http://akvod.com.ua/lichniy_kabinet/">личном кабинете</a>.<br>';

    if(isset($sozdana_uchetnaya_zapis) and $sozdana_uchetnaya_zapis and !$zaloginen){
        $tema='Создана учетная запись на АКВОД.com.ua';

        $text_pisma.='Для вас создана учетная запись АКВОД<br>';
        $text_pisma.='Перейдите на akvod.p.ht в свой личный кабинет, чтобы отлеживать ваш заказ<br>';
        $text_pisma.='Ваш логин: '.$e_mail.'<br>';
        $text_pisma.='Ваш пароль: '.$_SESSION['parol'].'<br>';
    }else {
        $tema='Ваш заказ АКВОДa';
    }

    $text_pisma.='Спасибо за заказ<br>';
    $text_pisma.='C уважением, Ваш АКВОД';

    mail($e_mail, $tema, $text_pisma, $headers);
}








//Отправляем оповещения о новом заказе менеджерам

//Выбираем из БД
$query = "SELECT
            `imya_admina`, `e-mail`
          FROM `Administratori_table`
          WHERE `uvedomlyat_na_email` = 'checked' ";

$rezult = mysql_query($query);
if(!$rezult){echo 'Ошибка получения списка менеджеров для оповещения'; echo mysql_error(); }


//Это запутанный блок кода получает из результата запроса к БД строку с адресатами,
//перечисленными через запятую в переменной $spisok_rassilki
$spisok_rassilki ='';
if(mysql_num_rows($rezult)>0){
    if(mysql_num_rows($rezult) == 1){
        $s = mysql_fetch_array($rezult, MYSQL_ASSOC);
        $spisok_rassilki = $s['e-mail'];
    }else {
        for($i=0; $i<mysql_num_rows($rezult); $i++) {
            $s = mysql_fetch_array($rezult, MYSQL_ASSOC);
            $spisok_rassilki .= $s['e-mail'];
            if($i<mysql_num_rows($rezult)){
                $spisok_rassilki .=", ";
            }
        }
    }
}


//Выписываем способ выбранный в заказе способ оплаты и доставки
$id_s_d = $danie_o_polzovatele_i_ego_zakaze["sposob_dostavki"];
$sposob_dostavki = $_SESSION['sposoby_dostavki_massiv'][$id_s_d]['naimenovanie_sposoba_dostavki'];

$id_s_o = $danie_o_polzovatele_i_ego_zakaze['sposob_oplati'];
$sposob_oplati = $_SESSION['sposoby_oplati_massiv'][$id_s_o]['naimenovanie_sposoba_oplati'];


//Составляем письмо
$e_mail = $spisok_rassilki;
$tema = "Новый заказ на AKVOD.com.ua -- №".$id_zakaza_last_added;
$text_pisma = "
            <html>
            <head>
            <meta http-equiv='content-type' content='text/html; charset=utf-8'>
            <title>
            Оповещение о новом заказе на AKVOD.com.ua
            </title>
            </head>
            <body>
                <ul>Автоматическое сообщение от робота АКВОД.com.ua</ul>
                <ul>Сим сообщаю, что на сайте AKVOD.com.ua Покупатель оставил новый заказ.</ul>
                <ul>Создан Заказ №"; $text_pisma.=$id_zakaza_last_added; $text_pisma.="</ul>";
$text_pisma .=" <ul>Заказ от ";
if($zaloginen) $text_pisma.="ЗАРЕГИСТРИРОВАННОГО"; else $text_pisma.="нового";
$text_pisma .=" пользователя.</ul>";
$text_pisma .=" <ul>Имя покупателя или наименование юр.лица: ".$danie_o_polzovatele_i_ego_zakaze['naimenovanie_pokupatelya']."</ul>
                <ul>Контактный телефон: ".$danie_o_polzovatele_i_ego_zakaze['telephon']."</ul>
                <ul>Заказ принят: ".date('l jS \of F Y h:i:s A')."</ul>
                <ul>Способ доставки: ".$sposob_dostavki."</ul>
                <ul>Адрес доставки: ".$danie_o_polzovatele_i_ego_zakaze["adress_dostavki"]."</ul>
                <ul>Способ оплаты: ".$sposob_oplati."</ul>
            </body>
                ";

$headers ="From: AKVOD <akvod@ukr.net>\nReply-to:akvod@ukr.ne\nContent-Type:text/html; charset=\"utf-8\"\n";

mail($e_mail, $tema, $text_pisma, $headers);








//ЗАВЕРШАЕМ СОЕДИНЕНИЕ С БД
mysql_close($connection);


//Очищаем корзину и другие переменные
unset($_SESSION['korzina']);
unset($_SESSION['danie_o_polzovatele_i_ego_zakaze']);
unset($_POST['sposob_dostavki']);
unset($_POST['sposob_oplati']);
unset($_POST['naimenovanie_pokupatelya']);
unset($_POST['telephon']);
unset($_POST['adress_dostavki']);
unset($_POST['primechanie_k_zakazu']);






//ТЕПЕРЬ ОТОБРАЖАЕМ СТРАНИЦУ
//отображаем стартовые объявления
echo '
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/css/main.css" media="all">
<title>
Оформить заказ
</title>
</head>

<body>
';


//Отображаем шапку

echo '

<div>

<a href="/" class="ssilka_v_punkte_menyu"> <!-- Отоюражаем логотип, который является ссылкой на главную страницу-->
    <img title="АКВОД - почвенный аккумулятор влаги" src="/img/2_akvod_logo_big.jpg" class="osnovnie_kartinki">
</a>

<span class="noselect zagolovok_stranitsi_pomenshe">Отчет обработки<br> заказа</span>
<img src="img/podsolnuh.jpg" title="Аквод способствует комфорту растений" class="osnovnie_kartinki pomestit_sprava">
';


echo '
</div>
';


//Верхний разделитель
echo '
<img title="" src="/img/3_verhniy_razdelitel.png" class="razdelitel">
';


//Отображаем принятый заказ
/*
 Данные введенные пользователем при регистрации
    СОстав принятого заказа
 */
echo 'Ваш заказ успешно принят<br>';
echo 'В течение суток с Вами свяжется наш менеджер для уточнения деталей<br>';
echo 'Номер вашего заказа: <strong>'.$id_zakaza_last_added.'</strong>.<br>';

if(isset($sozdana_uchetnaya_zapis) and $sozdana_uchetnaya_zapis and !$zaloginen){
    echo 'Также для Вас создана учетная запись. <br>';
    echo 'Логин: '.$_SESSION['email_via_login'].'<br>';
    echo 'Пароль: (в почтовом сообщении)<br>';
    echo 'Логин и пароль и ссылка на личный кабинет отправлены вам на '.$_SESSION['email_via_login'].'<br>';
    echo 'В личном кабинете вы можете отслеживать статус ваших заказов<br>';
}

if($zaloginen){
    echo 'На ваш е-мэйл: '.$e_mail.' отправлена квитанция о приеме заказа<br>';
    echo 'Свой заказ вы можете отслеживать в личном кабинете<br>';
}

echo 'Спасибо за Ваш заказ!<br>';

echo '<dir><a href="/index.php" title="Вернуться на Главную"><= Вернуться на главную</a> </dir>';




//Нижний разделитель
echo '
<img title="" src="/img/9_nizhniy_razdelitel.png" class="razdelitel">
';


//Отображаем подвал
include "../chasti_titula/podval.php";
