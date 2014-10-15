<?php
/* Корневой скрипт ЛИЧНОГО КАБИНЕТА*/

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












//ТЕПЕРЬ ОТОБРАЖАЕМ СТРАНИЦУ
//отображаем стартовые объявления
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/css/main.css" media="all">
<link rel="shortcut icon" href="/img/favicon.png" type="image/png">
<title>
Личный кабинет
</title>

<script type="text/javascript">

    function vizvat_stranitsu_izmeneniya_dannih(){
       document.location.href="/lichniy_kabinet/izmenit_dannie.php";
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
                echo '<dir>Чтобы зайти на эту страницу, необходимо ввести логин и пароль в поля в верхней части страницы</dir>';

}else{ //Если залогинен, то отображаем обзор данных пользователя

    //Основная часть страницы представлена в виде таблицы
    echo '<table><tr>'; //Начало таблицы



    //Ячейка таблицы с перечнем пунктов меню личного кабинета
    echo '<td class="yacheyka_s_formoy">';//Начало ячейки

    //Пункты меню
    echo '<dir><strong>Личные данные</strong></dir>';

    echo '<dir><a href="istoriya_zakazov.php">История заказов</a></dir>';

    echo '<dir><a href="rassilka_novostey.php">Рассылка новостей</a></dir>';


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
    echo 'Номер учетной записи: <strong>'.$_SESSION['id_pokupatelya'].'</strong><br>';
    echo 'Имя или Наименование для юридических лиц: <strong>'.$_SESSION['naimenovanie_pokupatelya'].'</strong><br>';
    echo 'Контактный телефон: <strong>'.$_SESSION['dannie_o_polzovatele']['telephon'].'</strong><br>';
    echo 'Контактный е-мэйл: <strong>'.$_SESSION['email_via_login'].'</strong><br>';
    echo 'Зарегистрирован: <strong>'.$_SESSION['dannie_o_polzovatele']['data_registratsii'].'</strong><br>';
    if(isset($_GET['rezultat_izmeneniya'])){
        echo '<dir>'.$_GET['rezultat_izmeneniya'].'</dir>';
    }
    echo '<dir><input type="button" onclick="vizvat_stranitsu_izmeneniya_dannih()" value="Изменить данные"></dir>';

    echo '</td>';//Конец ячейки




    echo '</tr></table>'; //КОнец таблицы
}




















//Нижний разделитель
echo '
<img title="" src="/img/9_nizhniy_razdelitel.png" class="razdelitel">
';


//Отображаем подвал
echo '

<a href="/chto_takoe_akvod/index.php?statiya=rezultati_i_sertifikati/rezultati_i_sertifikati.htm">
<span class="ssilka_v_punkte_menyu pomestit_sprava knopka_ssilka" title="Результаты исследований и сертификаты">Результаты исследований<br> и сертификаты</span>
</a>

</body>
</html>

';





?>