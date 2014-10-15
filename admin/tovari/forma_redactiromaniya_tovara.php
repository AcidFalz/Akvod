<?php
/* Вспомагательный скрипт отображения формы редактирования товара
Получает через GET id_tovara и выводит по умолчанию данные о этом товаре в форму.
Если id_tovara не задан, то создает запись о новом товаре*/

if(isset($_GET['id_tovara'])){
    //Подключаем БД
    include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
    $connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
    if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
    $db_select=mysql_select_db($db_database);//выбираем БД
    if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


    //Составляем и выбираем перечень статусов
    $query="SELECT * FROM `Tovari_table` WHERE `id_tovara`=".mysql_real_escape_string($_GET['id_tovara']);

    //Выполняем запрос
    $rezult=mysql_query($query);
    if(!$rezult){echo 'Ошибка выборки данных о товаре<br>'.mysql_error(); exit;}

    $tovar = mysql_fetch_array($rezult, MYSQL_ASSOC);


    /*
     $tovar = array (
                    `id_tovara`,
                    `nazvanie_tovara`,
                    `link_na_small_kartinku`,
                    `tsena`,
                    `nalichie_na_sklade`,
                    `opisanie_tovara`
                    )
    */


}

//Отображаем форму

echo '<ul class="strong">Описание товара</ul>';

echo '<form name="Forma">';
echo '<ul>';


echo  '<li class="punkt_formi">';
if(isset($tovar))echo '<input type="hidden" name="id_tovara" value="'.$tovar['id_tovara'].'">';

echo 'Название';
echo '<input type="text" name="nazvanie_tovara" size=50';
    if(isset($tovar))echo ' value="'.$tovar['nazvanie_tovara'];
echo '"><br>';
echo '</li>';


echo '<li class="punkt_formi">';
echo 'Цена';
echo '<input type="text" name="tsena" size=6';
if(isset($tovar)) echo ' value='.$tovar['tsena'];
echo '><br>';
echo '</li>';


echo '<li class="punkt_formi">';
//Select с вариантами наличия на складе
echo 'Наличие на складе';
echo '<select name="nalichie_na_sklade">';

echo '  <option value=1 ';
if(!isset($tovar) or (isset($tovar) and $tovar['nalichie_na_sklade']==1)) echo 'selected ';
echo '>Есть</option>';

echo '  <option value=2 ';
if(isset($tovar) and $tovar['nalichie_na_sklade']==0) echo 'selected ';
echo '>Нет</option>';

echo '</select><br>';
echo '</li>';


echo '<li class="punkt_formi">';
echo '<span id="nadpis_k_polyu_kartinki">Введите файла название картинки к товару (если картинка в отдельной папке, укажите в имени имя папки: напр. /akvod250/small.png</span><br>';
echo '<input type="text" name="link_na_small_kartinku" size="40"';
if(isset($tovar)) echo ' value="'.$tovar['link_na_small_kartinku'].'"';
echo '><br>';
echo '</li>';


echo '<li class="punkt_formi">';
echo 'Описание товара:<br>';
echo '<textarea name="opisanie_tovara" rows="9" cols="50">';
if(isset($tovar))echo $tovar['opisanie_tovara'];
echo '</textarea><br>';
echo '</li>';

echo '<input type="button" value="Отмена" onclick="document.getElementById(\'vsplivayuschee_okno\').style.display=\'none\'">';

echo '<input type="button" value="Сохранить" onclick="sohrahit_tovar(this';
if(isset($tovar)) echo ', \'sohranit\''; else echo ', \'sozdat\'';
echo ');">';

echo '</form>';