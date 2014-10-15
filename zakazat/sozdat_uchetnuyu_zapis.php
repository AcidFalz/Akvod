<?php
/** Скрипт для создания учетной записи АКВОД
 * Вызывается перед скриптом СОХРАНИТЬ_ЗАКАЗ.ПХП
 * Если пользователь хочет создать учетную запись
 */

/* Для информации Массив Корзины содержит следующие поля
$korzina[] = array(
    'id_tovara' => $_POST['id_tovara'],
    'nazvanie_tovara' => $_POST['nazvanie_tovara'],
    'tsena' => $_POST['tsena'],
    'kolichestvo_shtuk_v_zakaze' => $_POST['kolichestvo_shtuk_v_zakaze']

    );
*/

//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);



// стартуем сессию
session_start();



//Получаем содержимое КОРЗИНЫ
$korzina=$_SESSION['korzina'];



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
Создать учетную запись
</title>


</head>

<body>
<script type="text/javascript" src="zakazat.js"></script>
';


//Отображаем шапку

echo '

<div>

<a href="/" class="ssilka_v_punkte_menyu"> <!-- Отоюражаем логотип, который является ссылкой на главную страницу-->
    <img title="АКВОД - почвенный аккумулятор влаги" src="/img/2_akvod_logo_big.jpg" class="osnovnie_kartinki">
</a>

<span class="noselect zagolovok_stranitsi_pomenshe">Оформление<br> заказа</span>
<img src="img/podsolnuh.jpg" title="Аквод способствует комфорту растений" class="osnovnie_kartinki pomestit_sprava">
';


echo '
</div>
';


//Верхний разделитель
echo '
<img title="" src="/img/3_verhniy_razdelitel.png" class="razdelitel">
';




//Отображаем форму для заполнения учетной записи при создании  и содержимое корзины

echo '<table>
            <tr>';




echo '<td>'; // Ячейка с формой ввода

echo '<form name="Forma_zakaza" method="post" action="/zakazat/proverit_unikalnost_emaila.php" onsubmit="return proveritFormu_sozdat_uchetnuyu_zapis(this)">';
/* ФОрма содержит следующие поля
 sposob_dostavki
 sposob_oplati
 naimenovanie_pokupatelya
 telephon
 email_via_login
 adress_dostavki
 primechanie_k_zakazu
 parol
 parol2
 */


//Отображаем поле для ввода Е-МЕЙЛА
echo '<dir>Введите Ваш е-мэйл, чтобы сообщать вам статус вашего заказа, так же е-мэйл будет логином для входа<br>
      <input type="text" name="email_via_login" size="60"> </dir>';

if(isset($_GET['uzhe_est_takoy_email']) and $_GET['uzhe_est_takoy_email']){
    echo '<ul><i>Такой е-мэйл уже используется, выберите другой е-мэйл для регистрации.<br>
          Если это все таки ваш е-мэйл, значит вы его уже зарегистрировали.<br>
          Воспользуйтесь формой восстановления пароля</i></ul>';
    echo '<script>Forma_zakaza.email_via_login.focus();</script>';
}


//Отображаем поле для ввода пароля
echo '<dir>Придумайте пароль к вашей учетной записи и введите его в это поле:<br>
        <input type="password" name="parol" size="30"><br>';
echo 'Введите пароль ещё раз:<br>
        <input type="password" name="parol2" size="30"></dir>';


/* Прикольный Инпут
echo '
<p>Введите число от 1 до 10</p>
 <p><input type="range" min="1" max="10"></p>';
*/

//Отображаем кнопку СОХРАНИТЬ и ЗАКАЗАТЬ
echo '<input type="submit" value="СОХРАНИТЬ и ЗАКАЗАТЬ" title="Сохранить учетную запись и отправить заказ в обработку">';


echo '</form>';
echo '</td>'; //Конец ячейки с формой ввода





echo '<td>'; //Ячейка с корзиной

echo '<dir>'; //блок вывода корзины

    echo '<strong>Ваш заказ:</strong>';
    //Oбъявляем счетчик суммы заказа
    $summa_zakaza=0;

    //Счетчик списка пунктов заказа
    $schetchik = 0;




    foreach ($korzina as $pozitsiya_v_zakaze => $tovar_v_korzine) {
    //Построчно выводим содержимое корзины
        echo '<div>';

        /* это кнопка для удаления товара из корзины  */
        echo '<a href="udalit_iz_korzini.php?n='.$pozitsiya_v_zakaze.'&s=2" class="krestik_udalit"
                                                title="Удалить из корзины">x</a> '.($schetchik+1).') ';



        echo $tovar_v_korzine["nazvanie_tovara"].' - '.$tovar_v_korzine["kolichestvo_shtuk_v_zakaze"].'
                                                                шт * '.$tovar_v_korzine["tsena"].' грн';

        echo '='.$tovar_v_korzine["kolichestvo_shtuk_v_zakaze"]*$tovar_v_korzine["tsena"].' грн';
        echo '</div>';


        //суммируем счетчик суммы заказа
        $summa_zakaza += $tovar_v_korzine["kolichestvo_shtuk_v_zakaze"]*$tovar_v_korzine["tsena"];


        //Увеличиваем счетчик списка пунктов заказа
        $schetchik++ ;

    }

    //отображаем сумму заказа
    echo '<hr>';
    echo 'Итого товаров на сумму -- '.$summa_zakaza.' грн с НДС';
    echo '</dir>'; //конец блока вывода корзины

echo '</td>'; //Конец ячейки с корзиной

echo '</tr>';
echo '</table>';








//Нижний разделитель
echo '
<img title="" src="/img/9_nizhniy_razdelitel.png" class="razdelitel">
';


//Отображаем подвал
include "../chasti_titula/podval.php";



?>