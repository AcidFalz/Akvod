<?php
/* Основной скрипт блока продаж «Заказать»

Скрипт отображает перечень доступных товаром,
просматривать товары и добавлять можно анонимно.
Корзина сохраняется в массиве $_SESSION[].
Отправить заказ можно анонимно.
После авторизации можно сохранить заказ в учетной записи. */

/* Логика скрипта:
1)	Проверяем есть ли сессия.
Если нет, то инициируем сессию.
2)	Проверяем авторизирован ли пользователь,
Если ДА, то устанавливаем флаг “zalogonen”=YES,
Иначе устанавливаем флаг “zalogonen”=NO.
3)	Отображаем шапку (стартовые обявления)
4)	Отображаем ЛОГО
5)	Отображаем блок авторизации
Если “zalogonen”, то ИМЯ_ПОЛЬЗОВАТЕЛЯ и ссылку в личный кабинет.
Если НЕ “zalogonen”, то форму ввода логина/пароля, ссылку на скрипт регистрации,
также сохраняем линк скрипта на сам себя в переменной сессии “otsovskaya_stranitsa”
6)	Отображаем верхний разделитель
7)	Отображаем доступные товары
8)	Отображаем корзину и форму для предварительного ввода данных о заказе.
9)	Отображаем нижний разделитель
10)	Отображаем подвал

 */

/*Корзина имеет такие поля
$korzina[] = array(            // Добавляем к массиву корзины следующую запись
    'id_tovara' => $_POST['id_tovara'],
    'nazvanie_tovara' => $_POST['nazvanie_tovara'],
    'tsena' => $_POST['tsena'],
    'kolichestvo_shtuk_v_zakaze' => $_POST['kolichestvo_shtuk_v_zakaze']

    );
*/

//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);




//Инициируем сессию
session_start();




//УСТАНАВЛИВАЕМ СОЕДИНЕНИЕ С БАЗОЙ,

include ("../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли



//ФОРМИРУЕМ И ВЫПОЛНЯЕМ НЕОБХОДИМЫЕ ЗАПРОСЫ

//Список доступных товаров
$query = "SELECT * FROM `Tovari_table` where `nalichie_na_sklade`=1";//составить запрос перечня доступных товаров
$result_all=mysql_query($query);//выполнить запрос
if(!$result_all){echo ('Ошибка выборки списка товаров<br />'.mysql_error());}//проверяем выбрались ли

//Список доступных способов доставки
$query = "SELECT * FROM `Sposobi_dostavki_table` order by `id_sposoba_dostavki`"; //составляем запрос перечня способов доставки
$sposoby_dostavki_iz_bd = mysql_query($query);
if(!$sposoby_dostavki_iz_bd){echo ('Ошибка выборки списка способов доставки<br />'.mysql_error());}//проверяем выбрались ли

//Список доспуных способов оплаты
$query = "SELECT * FROM `Sposobi_oplati_table`"; //составляем запрос перечня способов доставки
$sposoby_oplati_iz_bd = mysql_query($query);
if(!$sposoby_oplati_iz_bd){echo ('Ошибка выборки списка способов оплаты<br />'.mysql_error());}//проверяем выбрались ли




//ЗАВЕРШАЕМ СОЕДИНЕНИЕ С БД
mysql_close($connection);


//Сохраняем результаты запросов списка способов доставки и оплаты в массивах
$sposoby_dostavki_massiv = array();
$sposoby_oplati_massiv = array();
for($i=1; $i<=mysql_num_rows($sposoby_dostavki_iz_bd); $i++){
    $s=mysql_fetch_array($sposoby_dostavki_iz_bd, MYSQL_ASSOC);
     $sposoby_dostavki_massiv[$s['id_sposoba_dostavki']]=$s;
}
for($i=1; $i<=mysql_num_rows($sposoby_oplati_iz_bd); $i++){
    $s=mysql_fetch_array($sposoby_oplati_iz_bd, MYSQL_ASSOC);
    $sposoby_oplati_massiv[$s['id_sposoba_oplati']]=$s;
}




//Сохраняем в переменных сессии массиы с доступными способами доставки и оплаты
$_SESSION['sposoby_dostavki_massiv']=$sposoby_dostavki_massiv;
$_SESSION['sposoby_oplati_massiv']=$sposoby_oplati_massiv;





// Получаем содержимое корзины
if(isset($_SESSION['korzina'])){
$korzina=$_SESSION['korzina'];

}


//ОТОБРАЖАЕМ СТРАНИЦУ
//отображаем стартовые объявления
/* 3)	Отображаем шапку (стартовые обявления) */


echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/css/main.css" media="all">
<link rel="shortcut icon" href="/img/favicon.png" type="image/png">
<title>
Заказать
</title>
</head>

<body>
';





//Отображаем шапку

echo '

    <div>

            <a href="/index.php"  class="ssilka_v_punkte_menyu"> <!-- 4)	Отображаем ЛОГО
            Отоюражаем логотип, который является ссылкой на главную страницу-->
                <img title="АКВОД - почвенный аккумулятор влаги" src="/img/2_akvod_logo_big.jpg" class="osnovnie_kartinki">
            </a>

            <span class="noselect zagolovok_stranitsi">ЗАКАЗАТЬ<br> АКВОД</span>
            <img src="img/smorodinka.jpg" title="Аквод способствует комфорту растений" id="kartinka_smorodinki" class="osnovnie_kartinki pomestit_sprava">
            ';



            //Отображаем блок авторизации



           include ('block_autorizatsii.php');


            echo '


    </div>
';


//  6)	Отображаем верхний разделитель
echo '
<img title="" src="/img/3_verhniy_razdelitel.png" class="razdelitel">
';








//ОТОБРАЖАЕМ ОСНОВНУЮ ЧАСТЬ
echo '
<table>
<tr>
';


//Отображаем доступные товары
echo '
<td class="lenta_tovarov">
';

if(mysql_num_rows($result_all)==0)echo 'Доступных товаров нет';

while($result_row=mysql_fetch_array($result_all)){


    echo '<form action="dobavit_v_korzinu.php" method="post" class="tovar_v_lente">';


    echo '<input type="hidden" value="'.$result_row["id_tovara"].'" name="id_tovara">';
    echo '<input type="hidden" value="'.$result_row["nazvanie_tovara"].'" name="nazvanie_tovara">';
    echo '<input type="hidden" value="'.$result_row["tsena"].'" name="tsena">';



    echo '   <img src="tovari_img/'.$result_row["link_na_small_kartinku"].'" title="" class="miniatura_tovara">'; // Отображаем миниатюру товара

    echo '  <p> <strong>'.$result_row["nazvanie_tovara"].'</strong> </p>';  //название товара

    echo '  <p> <input type="text" size="3" value="1" name="kolichestvo_shtuk_v_zakaze">';

    echo '   <input type="submit" value="добавить в корзину"> </p>';

    echo '<p class="tsena">Цена за упаковку <span name="tsena">'.$result_row["tsena"].' грн</span> </p>'; //цена товара


    echo '</form>';

}


echo '
</td>
';



//Отображаем корзину
echo '
<td class="korzina">
<strong>Корзина</strong>
<img src="img/korzinka.png" title=""><br>
';


if(empty($korzina)){
        echo 'Корзина пока пуста';
    }
else {

    //выводим содержимое корзины
    echo 'В корзине уже есть:<br>';

    echo '<form action="oformit.php" method="post">'; // формируем форму для корзины

    echo '<dir>'; //блок вывода корзины

    //Oбъявляем счетчик суммы заказа
    $summa_zakaza=0;

    //Счетчик списка пунктов заказа
    $schetchik = 0;



    foreach ($korzina as $pozitsiya_v_zakaze => $tovar_v_korzine) {
    //Построчно выводим содержимое корзины
        echo '<div>';


        /* это кнопка для удаления товара из корзины  */
        echo '<a href="udalit_iz_korzini.php?n='.$pozitsiya_v_zakaze.'&s=1" class="krestik_udalit" title="Удалить из корзины">x</a> '.($schetchik+1).') ';


        echo $tovar_v_korzine["nazvanie_tovara"].' - '.$tovar_v_korzine["kolichestvo_shtuk_v_zakaze"].' шт * '.$tovar_v_korzine["tsena"].' грн<br>';
        echo '='.$tovar_v_korzine["kolichestvo_shtuk_v_zakaze"]*$tovar_v_korzine["tsena"].' грн';
        echo '</div>';

        //суммируем счетчик суммы заказа
        $summa_zakaza += $tovar_v_korzine["kolichestvo_shtuk_v_zakaze"]*$tovar_v_korzine["tsena"];

        //Увеличиваем счетчик списка пунктов заказа
        $schetchik++ ;
    }

    //отображаем сумму заказа
    echo '<hr>';
    echo 'Итого -- '.$summa_zakaza.' грн с НДС';
    echo '</dir>'; //конец блока вывода корзины










    //Кнопка заказать
    echo '<input type="submit" value="Перейти к оформлению заказа">';




    echo '</form>'; //закрываем форму корзины
}


echo '
</td>
';

echo '
</tr>
</table>

';


//Нижний разделитель
echo '
<img title="" src="/img/9_nizhniy_razdelitel.png" class="razdelitel">
';


//Отображаем подвал
include "../chasti_titula/podval.php";


?>