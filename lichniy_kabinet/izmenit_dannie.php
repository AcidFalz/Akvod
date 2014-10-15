<?php
/* Скрипт редактирования данных в ЛИЧНОМ КАБИНЕТЕ*/



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
    echo '<script language="JavaScript">document.location.href="index.php"</script>';
    exit;
}












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

    function vizvat_stranitsu_index(){
       document.location.href="/lichniy_kabinet/index.php";
    }

    function proveritFormu(form){

        if(Forma_zakaza.naimenovanie_pokupatelya.value==""){
        alert("Не указано Имя или Наименование!");
        Forma_zakaza.naimenovanie_pokupatelya.focus();
        return false;
        }

        if(Forma_zakaza.telephon.value==""){
        alert("Не указан телефон!");
        Forma_zakaza.telephon.focus();
        return false;
        }
    return true;
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

//Верхний разделитель
echo '
<img title="" src="/img/3_verhniy_razdelitel.png" class="razdelitel">
';




//Если не залогинен, то отбражаем форму авторизации
if(!$zaloginen){
                echo '
                <form action="/zakazat/priznat.php" method="post">
                Логин
                <input type="text" width="10" name="login">
                Пароль
                <input type="password" width="10" name="parol">

                <input type="hidden" name="otsovskaya_stranitsa" value="'.$_SERVER['PHP_SELF'].'">

                <input type="submit" value="вход">
                </form>';
                if(isset($_GET['oshinka_avtorizatsii']))
                {   echo '<span>'.$_GET['oshinka_avtorizatsii'].' </span>';

                    if($_GET['oshinka_avtorizatsii']=='Неверный логин или пароль'){
                        echo '<a href="../vosstanovit_parol/index.php"> Восстановить пароль</a>';
                    }
                }
}else{ //Если залогинен, то отображаем обзор данных пользователя

    //Основная часть страницы представлена в виде таблицы
    echo '<table><tr>'; //Начало таблицы



    //Ячейка таблицы с перечнем пунктов меню личного кабинета
    echo '<td>';//Начало ячейки

    echo '<dir><strong>Личные данные</strong></dir>';

    echo '<dir><a href="istoriya_zakazov.php">История заказов</a></dir>';

    echo '<dir><a href="rassilka_novostey.php">Рассылка новостей</a></dir>';

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

        //Открываем форму
        echo '<form name="Forma_zakaza" method="post" action="/lichniy_kabinet/vnesti_izmeneniya_v_bazu.php" onsubmit="return proveritFormu(this)">';
        echo 'Номер учетной записи: <strong>'.$_SESSION['id_pokupatelya'].'</strong><br>';
        echo '<input type="hidden" name="id_pokupatelya" value="'.$_SESSION['id_pokupatelya'].'">';
        echo 'Имя или Наименование для юридических лиц: <input type="text" name="naimenovanie_pokupatelya" value="'.$_SESSION['naimenovanie_pokupatelya'].'"><br>';
        echo 'Контактный телефон: <input type="text" name="telephon" value="'.$_SESSION['dannie_o_polzovatele']['telephon'].'"><br>';
        echo 'Контактный е-мэйл: <strong>'.$_SESSION['email_via_login'].'</strong><br>';
        echo 'Зарегистрирован: <strong>'.$_SESSION['dannie_o_polzovatele']['data_registratsii'].'</strong><br>';
        echo '<dir><input type="button" onclick="vizvat_stranitsu_index()" value="Отменить">';
        echo '<input type="submit" value="Сохранить"></dir>';
        echo '</form>';

    echo '</td>';//Конец ячейки




    echo '</tr></table>'; //Начало таблицы
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