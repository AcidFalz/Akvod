<?php
/* Вспомагательный скрипт для добавления записи в корзину
*/

/*  Логика скрипта
1)	получить через POST поля по добавляемому товару
это:
id_tovara
nazvanie_tovara
tsena
kolichestvo_shtuk_v_zakaze

2) проверить, чтобы не ноль штук в строке заказа, иначе прекратить выполнение скрипта
3) проверить, чтобы не было уже такой позиции в корзине, иначе добавить к существующему количеству
4)	добавить в массив $_SESSION[‘korzina’] строку массива с полями по добавляемому товару
5)	вызвать скрипт zakazat/index.php

*/


//Показывать все ошибки
ini_set('display_errors',1);
error_reporting(E_ALL);





session_start();                 // стартуем сессию


$korzina = array();

if(isset($_SESSION['korzina'])){// Получаем через переменную сессии текущее содержимое корзины
$korzina=$_SESSION['korzina'];
   // echo 'Получаем через переменную сессии текущее содержимое корзины<br>';
}//else echo '$korsina ne opredelena<br>';



//Если в строке заказа не нуль штук, то продолжаем дальше, иначе сразу вызываем родительский скрипт.
if($_POST['kolichestvo_shtuk_v_zakaze']==0) {
    echo '<script language="JavaScript">document.location.href="index.php"</script>';  // Вызываем родительский скрипт zakazat/index.php
    //echo '<a href="index.php">zkazat\index</a>';
    //echo 'в строке заказа ноль штук';
    exit;
}//else echo 'в строке штук больше нуля<br>';


//Если в карзине нет такого наименования, то продолжаем дальше
//иначе добавляем количество к текущему количеству и прерываем выполнение скрипта

if(isset($_SESSION['korzina'])){
    //echo 'перебираем товары в корзине<br>';
    foreach($korzina as $pozitsiya_v_zakaze => $tovar_v_korzine) {    //перебираем товары в корзине
        if(in_array($_POST['id_tovara'],$tovar_v_korzine)){  //сравниваем названия

            //echo 'есть повторяющая строка в корзине<br>';
           // echo 'было в заказе --'.$tovar_v_korzine["kolichestvo_shtuk_v_zakaze"].'шт '.$tovar_v_korzine["nazvanie_tovara"].'<br>';

            $tovar_v_korzine['kolichestvo_shtuk_v_zakaze'] += $_POST['kolichestvo_shtuk_v_zakaze'];  //и если находим существующий, то добавляем к существующему количество в новой строке
            $korzina[$pozitsiya_v_zakaze]['kolichestvo_shtuk_v_zakaze']=$tovar_v_korzine['kolichestvo_shtuk_v_zakaze'];

            //echo 'стало в заказе --'.$tovar_v_korzine["kolichestvo_shtuk_v_zakaze"].'шт<br>';
           // echo '<a href="index.php">zkazat\index</a>';

            $_SESSION["korzina"] = $korzina;  // Помещаем содержимое корзины в переменную сессии

           // print_r($korzina);
           // echo '<br> vtoroy massiv';
           // print_r($_SESSION["korzina"]);

            echo '<script language="JavaScript">document.location.href="index.php"</script>';  // Вызываем родительский скрипт zakazat/index.php

            //echo 'прекращаем выполнение скрипта';
            exit; //прекращаем выполнение скрипта
        }
    }
}

//echo 'Добавляем к массиву корзины следующую запись<br>';

$korzina[] = array(            // Добавляем к массиву корзины следующую запись
    'id_tovara' => $_POST['id_tovara'],
    'nazvanie_tovara' => $_POST['nazvanie_tovara'],
    'tsena' => $_POST['tsena'],
    'kolichestvo_shtuk_v_zakaze' => $_POST['kolichestvo_shtuk_v_zakaze']

    );


//echo 'Помещаем содержимое корзины в переменную сессии';

$_SESSION["korzina"] = $korzina;  // Помещаем содержимое корзины в переменную сессии

echo '<script language="JavaScript">document.location.href="index.php"</script>';  // Вызываем родительский скрипт zakazat/index.php

//echo '<a href="index.php">zkazat\index</a>';

?>