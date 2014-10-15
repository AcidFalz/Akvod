<?php
/* Скрипт управления рассылкой новостей */

//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);




//Инициируем сессию
session_start();



/*
2)	Проверяем авторизирован ли пользователь,
Если ДА, то устанавливаем флаг “zalogonen”=YES,
Иначе устанавливаем флаг “zalogonen”=NO.
 */

if(isset($_SESSION['id_pokupatelya'])){
    $zaloginen = 1;
}
else{
    $zaloginen = 0;
}


if($zaloginen){
//========================================================
//Проверяем подписан ли?

    //УСТАНАВЛИВАЕМ СОЕДИНЕНИЕ С БАЗОЙ,

    include ("../db/db_connect.php");//подключаем файл с параметрами соединения
    $connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
    if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
    $db_select=mysql_select_db($db_database);//выбираем БД
    if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


    //ФОРМИРУЕМ И ВЫПОЛНЯЕМ НЕОБХОДИМЫЕ ЗАПРОСЫ
    /* Пописан ли?   */
    $query ="SELECT *
             FROM `Podpischiki_na_novosti_table`
             WHERE `e-mail_podpischika`=\"".$_SESSION['email_via_login']."\"";

    $result=mysql_query($query);//выполнить запрос
    if(!$result){echo ('Ошибка выборки данных о участии в рассылке<br />'.mysql_error()); exit;}//проверяем выбрались ли

    //Подписан или отписан: ставим соответствующий флаг
    if(mysql_num_rows($result)>0) $podpisan = 1;
    else $podpisan = 0;


//========================================================
//Если не подписан и "Подписать", то ПОДПИСАТЬ
    if(!$podpisan and isset($_GET['p_ili_o']) and $_GET['p_ili_o'] == "podpisat"){

        //Составляем запрос на внесение записи в БД
        $query = "INSERT INTO
                            `Podpischiki_na_novosti_table`
                            (`id_podpischika`,
                             `e-mail_podpischika`)
                        VALUES
                            (NULL,
                            '";
             $query .= $_SESSION['email_via_login'];
             $query .= "')";

        $result=mysql_query($query);//выполнить запрос
        if(!$result){echo ('Ошибка вставки е-мэйла в список рассылки<br />'.mysql_error());}//проверяем выбрались ли

        if($result)$podpisan = 1;

    }


//========================================================
//Если подписан и "Отписать", то ОТПИСАТЬ
    if($podpisan and isset($_GET['p_ili_o']) and $_GET['p_ili_o'] == "otpisat"){
        //Составляем запрос на внесение записи в БД
        $query = "DELETE FROM
                     `Podpischiki_na_novosti_table`
                   WHERE `e-mail_podpischika`='";
                     $query .= $_SESSION['email_via_login'];
                     $query .= "'";

        $result=mysql_query($query);//выполнить запрос
        if(!$result){echo ('Ошибка удаления е-мэйла из списока рассылки<br />'.mysql_error());}//проверяем выбрались ли

        if($result)$podpisan = 0;

    }

    mysql_close($connection);
} //конец IF работа с БД (Подписать/Отписать)



//ТЕПЕРЬ ОТОБРАЖАЕМ СТРАНИЦУ
//отображаем стартовые объявления
echo '
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/css/main.css" media="all">
<link rel="shortcut icon" href="/img/favicon.png" type="image/png">
<title>
Личный кабинет
</title>

<script type="text/javascript" language="javascript">

    function podpisat_ili_otpisat(p_ili_o){
       document.location.href="/lichniy_kabinet/rassilka_novostey.php?p_ili_o="+p_ili_o;
    }

</script>


</head>

<body>
';


//Отображаем шапку


echo '

<div>

<a href="/" class="ssilka_v_punkte_menyu"> <!-- Отоюражаем логотип, который является ссылкой на главную страницу-->
    <img title="АКВОД - почвенный аккумулятор влаги" src="/img/2_akvod_logo_big.jpg" class="osnovnie_kartinki">
</a>

<span class="noselect zagolovok_stranitsi_pomenshe">Личный кабинет</span>

</div>

<img src="/lichniy_kabinet/img/podsolnuh.jpg" title="Аквод способствует комфорту растений" class="podsolnuh_v_lichnom_kabinete pomestit_sprava">
';
            //Отображаем блок авторизации
            echo '
            <span class="forma_avtorizatsii"><!-- правая часть шапки -->
            ';


include ('../zakazat/block_autorizatsii.php');


            echo '
            </span>


';

//Верхний разделитель
echo '
<img title="" src="/img/3_verhniy_razdelitel.png" class="razdelitel">
';




//Если не залогинен, то отбражаем форму авторизации
if(!$zaloginen){
                echo '<dir>Чтобы зайти на эту страницу, нужно ввести логин и пароль в поля в верхней части страницы</dir>';

}else{ //Если залогинен, то отображаем обзор данных пользователя

    //Основная часть страницы представлена в виде таблицы
    echo '<table><tr>'; //Начало таблицы



    //Ячейка таблицы с перечнем пунктов меню личного кабинета
    echo '<td class="yacheyka_s_formoy">';//Начало ячейки

    //Пункты меню
    echo '<dir><a href="index.php">Личные данные</a></dir>';

    echo '<dir><a href="istoriya_zakazov.php">История заказов</a></dir>';

    echo '<dir><strong>Рассылка новостей</strong></dir>';


    echo '</td>';//Конец ячейки


    //Ячейка таблицы с обзором пунтка меню
    echo '<td class="otstupit_nemnogo_sleva pole-yacheyka_otobrazhenie_statyi">';//Начало ячейки
    /* В массиве имеем такие поля
        $_SESSION['dannie_o_polzovatele']= array(
                `id_pokupatelya`,
                `naimenovanie_pokupatelya`,
                `telephon`,
                `email_via_login`,
                `data_registratsii`
                 )
    */

    if($podpisan){
        echo '<div>Ваш е-мэйл <br><strong>'.$_SESSION['email_via_login'].'</strong> <br>включен<br> в список рассылки новостей</div>';
        echo '<div><input type="button" onclick="podpisat_ili_otpisat(\'otpisat\')" value="Отписаться"></div>';
    }

    if(!$podpisan) {
        echo '<div>Чтобы подписаться на рассылку новостей нажмите кнопку</div>';
        echo '<div><input type="button" onclick="podpisat_ili_otpisat(\'podpisat\')" value="Подписаться"></div>';
    }




    echo '</td>';//Конец ячейки с обзором пунтка меню




    echo '</tr></table>'; //КОнец таблицы
}




















//Нижний разделитель
echo '
<img title="" src="/img/9_nizhniy_razdelitel.png" class="razdelitel">
';


//Отображаем подвал
echo '

<a href="/chto_takoe_akvod/index.php?statiya=rezultati_i_sertifikati/rezultati_i_sertifikati.htm">
<span class="pomestit_sprava knopka_ssilka" title="Результаты исследований и сертификаты">Результаты исследований<br> и сертификаты</span>
</a>

</body>
</html>

';





?>