<?php
/* Скрипт для оформления заказа
ВНИМАНИЕ! В коде используется прямая привязка в данным из базы:
считается, что способ оплаты по безналу имеет в БД номер 1 (строка 202 на 13-авг)
*/


//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);




// стартуем сессию
session_start();




//Проверить есть ли korzina в переменных сессии, если нет, то переправить на zakazat/index.php
//если есть, то получаем содержимое корзины
if(isset($_SESSION['korzina'])||!empty($_SESSION['korzina'])){
$korzina=$_SESSION['korzina'];
}
else {// Вызываем родительский скрипт zakazat/index.php
 echo '<script language="JavaScript">document.location.href="index.php"</script>';
      }

//Если корзина пуста, то вызываем родительский скрипт zakazat/index.php
//Дублирую вторую проверку условия на случай, если последний товар из корзины будет удален с этой страницы
if(empty($korzina)){
        echo '<script language="JavaScript">document.location.href="index.php"</script>';
    }





//Получаем доступные способы доставки и оплаты
$sposoby_dostavki_massiv=$_SESSION['sposoby_dostavki_massiv'];
$sposoby_oplati_massiv=$_SESSION['sposoby_oplati_massiv'];



//ТЕПЕРЬ ОТОБРАЖАЕМ СТРАНИЦУ
//отображаем стартовые объявления
echo '
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/css/main.css" media="all">
<link rel="shortcut icon" href="/img/favicon.png" type="image/png">
<title>
Оформить заказ
</title>

<script type="text/javascript" src="zakazat.js"></script>


</head>

<body>
';




//Отображаем шапку

echo '

<div>

<a href="/" class="ssilka_v_punkte_menyu"> <!-- Отоюражаем логотип, который является ссылкой на главную страницу-->
    <img title="АКВОД - почвенный аккумулятор влаги" src="/img/2_akvod_logo_big.jpg" class="osnovnie_kartinki">
</a>

<span class="noselect zagolovok_stranitsi_pomenshe">Заказать АКВОД</span>
<img src="img/podsolnuh.jpg" title="Аквод способствует комфорту растений" class="osnovnie_kartinki pomestit_sprava">
';


//Отображаем блок авторизации пользователя.
include ('block_autorizatsii.php');


echo '
</div>
';




//Верхний разделитель
echo '
<img title="" src="/img/3_verhniy_razdelitel.png" class="razdelitel">
';



//ОСНОВНАЯ ЧАСТЬ

echo '<span><a href="/zakazat/index.php" title="Вернуться к составлению заказа"><= Назад к составлению заказа</a> </span>';


//Открываем ФОРМУ
echo '<form name="Forma_zakaza" id="Forma_zakaza" method="POST" action="sohranit_zakaz.php" onsubmit="return proveritFormu(this)">';


//Отображаем содержимое корзины

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






//Отобразить форму и заполнить её данными заказа
/* В форме присутствуют такие поля
sposob_dostavki
sposob_oplati
naimenovanie_pokupatelya
telephon
adress_dostavki
primechanie_k_zakazu

 *
 */


    //Способ доставки
    echo '<dir>'; //Блок способа доставки
    echo 'Способ доставки: <br>';


    echo '<select name="sposob_dostavki">';
    echo '<option disabled selected value="0">Выберите способ доставки</option>';

    foreach ($sposoby_dostavki_massiv as $i => $s) {
        echo '<option value="'.$s["id_sposoba_dostavki"].'">'.$s["naimenovanie_sposoba_dostavki"].'</option>';
           }

    echo '</select>'; //завершаем выпадающий список способа доставки

/* Пока заглушаю часть скрипта, динамически отображающую комментарий по выбранному способу доставки
<select name="sposob_dostavki" onchange="display_comment ();"  size="100">
    //Здесь будет выводиться комментарий по выбранному способу доставки
    echo '<dir id="opisanie_sposoba_dostavki">Здесь будет отображен комментарий по выбранному способу доставки</dir>';

    //Скрипт добавляющий комментарий по выбранному способу доставки
    echo '
            <script type = "text/javascript" language="JavaScript">
                function display_comment(){
                    var comment=document.getElementById("opisanie_sposoba_dostavki");
                    comment.innerText="вот такой коментарий!!"
                }
            </script>

    ';
*/

    echo '</dir>'; //Конец блока способа доставки




    //Способ оплаты
    echo '<dir>'; //Блок способа оплаты
    echo 'Способ оплаты:<br>';

    echo '<select name="sposob_oplati">';
    echo '<option disabled selected value="0">Выберите способ оплаты</option>';

    foreach($sposoby_oplati_massiv as $i => $s) {
                   echo '<option value="'.$s["id_sposoba_oplati"].'">'.$s["naimenovanie_sposoba_oplati"].'</option>';
           }

    echo '</select>'; //завершаем выпадающий список способа оплаты
    echo '</dir>'; //Конец блока способа оплаты






//Отображаем поле для ввода ИМЕНИ
if($zaloginen){
    echo '<dir>Ваше ИМЯ либо НАИМЕНОВАНИЕ для юридического лица<br>
          <input type="text" name="naimenovanie_pokupatelya" size="100" value='.$_SESSION['naimenovanie_pokupatelya'].'>
          </dir>';

}else{
    echo '<dir>Введите Ваше ИМЯ либо НАИМЕНОВАНИЕ для юридического лица<br>
          <input type="text" name="naimenovanie_pokupatelya" size="100"></dir>';
}

//Отображаем поле для ввода КОНТАКТНОГО ТЕЛЕФОНА
if($zaloginen){
    echo '<dir>Введите контактный номер телефона по этому заказу<br>
          <input type="text" name="telephon" size="100" value="'.$_SESSION['dannie_o_polzovatele']['telephon'].'"></dir>';

}else {
    echo '<dir>Введите контактный номер телефона по этому заказу<br>
      <input type="text" name="telephon" size="100"></dir>';
}

//Отображаем поле для ввода АДРЕСА ДОСТАВКИ
echo '<dir>Введите адрес для доставки<br>
      <input type="text" name="adress_dostavki" size="100"> </dir>';

//Отображаем поле для ввода КОММЕНТАРИЯ К ЗАКАЗУ
echo '<dir>Комментарии к заказу<br>
      <textarea cols=50 rows=10 name="primechanie_k_zakazu"> </textarea></dir>';


//Отображаем галочку Создать ли учетную запись, если незалогинен сущ.пользователь
if(!$zaloginen){
echo '<dir>
        <input type="checkbox" onchange="changeActionForForm(this);" name="galochka_dlya_parolya">
            Создать учетную запись Аквод
      </dir>';
}


//Отображаем кнопку ЗАКАЗАТЬ
echo '<input type="submit" value="ЗАКАЗАТЬ" title="Отправить заказ в обработку">';


//Закрываем форму
echo '</form>';







//Нижний разделитель
echo '
<img title="" src="/img/9_nizhniy_razdelitel.png" class="razdelitel">
';


//Отображаем подвал
include "../chasti_titula/podval.php";



?>
