<?php
/* Скрипт ЛИЧНОГО КАБИНЕТА С ИСТОРИЕЙ ЗАКАЗОВ*/



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
//УСТАНАВЛИВАЕМ СОЕДИНЕНИЕ С БАЗОЙ,

include ("../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли



//ФОРМИРУЕМ И ВЫПОЛНЯЕМ НЕОБХОДИМЫЕ ЗАПРОСЫ

//Перечень заказов и даные о них
/* выбираем: номер заказа, дату заказа, сумму заказа, состояние заказа
*/

$query = "SELECT
	t1.id_zakaza AS nomer_zakaza,
	t1.data_zakaza,
	SUM( t2.kolichestvo_shtuk_tovara_v_zakaze * t3.tsena ) AS summa_zakaza,
	t4.naimenovanie_statusa AS status_zakaza
FROM Zakazi_table AS t1
JOIN Sostav_zakaza_table AS t2 ON t1.id_zakaza = t2.id_zakaza
JOIN Tovari_table AS t3 ON t2.id_tovara = t3.id_tovara
JOIN Vozmozhnie_statusi_zakaza_table AS t4 ON t1.id_statusa_zakaza = t4.id_statusa
WHERE t1.id_pokupatelya =".$_SESSION['id_pokupatelya']."
GROUP BY t1.id_zakaza";//составить запрос истории заказов

$result=mysql_query($query);//выполнить запрос
if(!$result){echo ('Ошибка выборки данных о истории заказов<br />'.mysql_error()); exit;}//проверяем выбрались ли

$istoria_zakazov_massiv = array();
$kolichectvo_zakazov=mysql_num_rows($result);
for($i=0; $i<$kolichectvo_zakazov; $i++){
$istoria_zakazov_massiv[]=mysql_fetch_array($result, MYSQL_ASSOC);
}

    mysql_close($connection);

}//конец блока: Запрос к БД истории заказов



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


<script type="text/javascript" src="../js/glavnaya.js"></script>



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
            echo '<dir><a href="index.php"><nobr>Личные данные</nobr></a></dir>';

            echo '<dir><strong><nobr>История заказов</nobr></strong></dir>';

            echo '<dir><a href="rassilka_novostey.php"><nobr>Рассылка новостей</nobr></a></dir>';



        echo '</td>';//Конец ячейки




        //Ячейка таблицы с обзором пунтка меню
        echo '<td>';//Начало ячейки
        /* В массиве имеем такие поля
            $_SESSION['dannie_o_polzovatele']= array(
                    `id_pokupatelya`,
                    `naimenovanie_pokupatelya`,
                    `telephon`,
                    `email_via_login`,
                    `data_registratsii`
                     )
        */

        //Всплывающее окно с составом заказа
        echo '<div id="divokno">';
        echo '<div class="knopka_krestik_zakrit" onclick="document.getElementById(\'divokno\').style.display=\'none\'">X</div>';
        echo '<span id="mesto_vstavki_sostava_zakaza">А вот вам здрасьте!></span>';
        echo '<input type="button" class="knopka_Ok" value="Ok" onclick="document.getElementById(\'divokno\').style.display=\'none\'">';
        echo '</div>';




        //ОТОБРАЖАЕМ ПЕРЕЧЕНЬ ЗАКАЗОВ И ДАННЫЕ О НИХ

    if($kolichectvo_zakazov > 0){
    /* Массив заказов содержит такие поля
    $istoria_zakazov_massiv[]= array (
                    `nomer_zakaza`,
                    `data_zakaza`,
                    `summa_zakaza`,
                    `status_zakaza`,
                    )
    */


        echo '<table>'; //Начало внутренней таблицы с историей заказов

        echo '<tr>';  //Строка заголовков
        echo '  <td>Номер заказа</td>';
        echo '  <td>Дата заказа</td>';
        echo '  <td>Сумма заказа</td>';
        echo '  <td>Статус заказа</td>';
        echo '</tr>'; //Конец строки заголовков

        foreach($istoria_zakazov_massiv as $ocherednoy_zakaz){
            echo '<tr class="stroka_istorii_zakaza">';
            echo '<td>№'.$ocherednoy_zakaz["nomer_zakaza"].'</td>';
            echo '<td>'.$ocherednoy_zakaz["data_zakaza"].'</td>';
            echo '<td>'.$ocherednoy_zakaz["summa_zakaza"].' грн</td>';
            echo '<td>'.$ocherednoy_zakaz["status_zakaza"].'</td>';
            echo '<td><input type="button" onclick="Pokazat_Sostav_Zakaza('.$ocherednoy_zakaz["nomer_zakaza"].');" value="состав"></td>';
            echo '</tr>';
        }

        echo '</table>'; //Конец внутренней таблицы с историей заказов


    } else echo '<ul class="otstupit_nemnogo_sleva pole-yacheyka_otobrazhenie_statyi">Заказов пока нет</ul>';



        echo '</td>';//Конец ячейки




    echo '</tr></table>'; //Конец таблицы
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