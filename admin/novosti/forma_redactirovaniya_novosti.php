<?php
/* Вспомагательный скрипт отображения формы редактирования новости
Получает через GET id_novosti и выводит по умолчанию данные о этоq новости в форму.
Если id_novosti не задан, то создает запись о новоq новости*/

if(isset($_GET['id_novosti'])){
    //Подключаем БД
    include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
    $connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
    if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
    $db_select=mysql_select_db($db_database);//выбираем БД
    if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


    //Составляем и выбираем перечень статусов
    $query="SELECT * FROM `Novosti_table` WHERE `id_novosti`=".mysql_real_escape_string($_GET['id_novosti']);

    //Выполняем запрос
    $rezult=mysql_query($query);
    if(!$rezult){echo 'Ошибка выборки данных о новости<br>'.mysql_error(); exit;}

    $novost = mysql_fetch_array($rezult, MYSQL_ASSOC);


    /*
     $novost = array (
                    `id_novosti`,
                    `data_vihoda_novosti`,
                    `nazvanie_novosti`,
                    `anons_of_a_new`,
                    `path_to_a_new`,
                    `miniatyura_img`,
                    `opublikovana`
                    )
    */


}


//Отображаем окно подсказки
echo '<ul class="okno_podskazki" id="okno_podskazki">
      <ul class="knopka_krestik_zakrit" onclick="document.getElementById(\'okno_podskazki\').style.display=\'none\'">X</ul>';
      include '../novosti/Instruktsiya_dobavleniya_novosti.htm';
echo '</ul>';


//Отображаем форму
if(isset($_GET['id_novosti']))echo '<ul class="strong">Редактирование новости</ul>';
else echo '<ul class="strong">Добавление новости</ul>';


echo '<form name="Forma" id="Forma">';
echo '<ul>';


echo  '<li class="punkt_formi">';
if(isset($novost))echo '<input type="hidden" name="id_novosti" value="'.$novost['id_novosti'].'">';

echo 'Дата выхода новости';
echo '<input type="text" name="data_vihoda_novosti" size=12 id="data_vihoda_novosti"';
    if(isset($novost))echo ' value="'.$novost['data_vihoda_novosti'];
echo '"><input type="button" value="<= Сегодня" onclick="
                                                var dt=new Date();
                                                var month = dt.getMonth()+1;
                                                if (month<10) month=\'0\'+month;
                                                var day = dt.getDate();
                                                if (day<10) day=\'0\'+day;
                                                var year = dt.getFullYear();
                                                document.getElementById(\'data_vihoda_novosti\').value=year+\'-\'+month+\'-\'+day;
                                                "><br>';
echo '</li>';


echo '<li class="punkt_formi">';
echo 'Заголовок';
echo '<input type="text" name="nazvanie_novosti" size="40"';
if(isset($novost)) echo ' value="'.$novost['nazvanie_novosti'];
echo '"><br>';
echo '</li>';


echo '<li class="punkt_formi">';
echo 'Анонс новости:<br>';
echo '<textarea name="anons_of_a_new" rows="9" cols="50">';
if(isset($novost))echo $novost['anons_of_a_new'];
echo '</textarea><br>';
echo '</li>';


echo '<li class="punkt_formi">';
echo '<span id="nadpis_k_polyu_anonsa">Введите путь к файлу статьи (если статья в отдельной папке, укажите в имени файла имя папки: напр. arhiv_novostey/novaya_fasovka_akvod/index.htm</span><br>';
echo '<input type="text" name="path_to_a_new" size="65"';
if(isset($novost)) echo ' value="'.$novost['path_to_a_new'].'"';
echo '><br>';
echo '</li>';


echo '<li class="punkt_formi">';
echo '<span id="miniatyura_img">Введите путь к файлу картинки-миниатюры к новости размером 95х85px: напр. /novosti/arhiv_novostey/otkritie_saita_akvod/miniatyura.jpg</span><br>';
echo '<input type="text" name="miniatyura_img" size="65"';
if(isset($novost)) echo ' value="'.$novost['miniatyura_img'].'"'; else echo ' value="/img/2_akvod_logo_big.jpg"';
echo '><br>';
echo '</li>';



echo '<li class="punkt_formi">';
//Select с вариантами наличия на складе
echo 'Опубликована';
echo '<select name="opublikovana">';

echo '  <option value=1 ';
if(!isset($novost) or (isset($novost) and $novost['opublikovana']==1)) echo 'selected ';
echo '>Да</option>';

echo '  <option value=2 ';
if(isset($novost) and $novost['opublikovana']==0) echo 'selected ';
echo '>Нет</option>';

echo '</select><br>';
echo '</li>';

echo '<li class="punkt_formi">';
echo '<input type="checkbox" name="razoslat" checked> Разослать по списку рассылки';
echo '</li>';

echo '<input type="button" value="Отмена" onclick="document.getElementById(\'vsplivayuschee_okno\').style.display=\'none\'">';

echo '<input type="button" value="';
if(isset($novost)) echo 'Сохранить'; else echo 'Опубликовать';
echo '" onclick="sohrahit_novost(this';
if(isset($novost)) echo ', \'sohranit\''; else echo ', \'sozdat\'';
echo ');">';

echo '</form>';