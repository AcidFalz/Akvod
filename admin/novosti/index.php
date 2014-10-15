<?php
/* Скрипт-часть админ странички про Новости
    Содержит вызов редактирования новости и добавления новости
*/

//Подключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


//Составляем и выбираем перечень товаров
$query ="SELECT * FROM `Novosti_table`";

//Выполняем запрос
$rezult=mysql_query($query);
if(!$rezult){echo 'Ошибка выборки списка новостей<br>'.mysql_error(); exit;}

//Сохраняем результат
$kolichestvo_novostey = mysql_num_rows($rezult);
for($i=0; $i<$kolichestvo_novostey; $i++){
    $spisok_novostey[]=mysql_fetch_array($rezult,MYSQL_ASSOC);
}

/* В итоге в массиве содержатся такие поля
    $spisok_novostey = array (
                `id_novosti`,
                `data_vihoda_novosti`,
                `nazvanie_novosti`,
                `anons_of_a_new`,
                `path_to_a_new`,
                `opublikovana`
                )
*/

//Закрываем соединение с БД
mysql_close();


//Сразу создаем всплывающее окно для отображения новости и редактирования новости
echo '<ul id="vsplivayuschee_okno">
        <span id="mesto_v_okne_dlya_vivoda"></span>
      </ul>';

echo '<input type="button" value="Создать новость" onclick="otobrazit_formu_redaktirovamiya_novosti();">';
if(isset($spisok_novostey)) {

    echo '<table>';

    echo '<caption class="strong">Список новостей</caption>';
    echo '<thead>';
    echo '  <tr>
                <td>
                    <nobr>п/п</nobr>
                </td>
               <td>
                    #id новости
                </td>
                <td>
                    Дата выхода новости
                </td>
               <td>
                    Название новости
                </td>
                <td>
                    Опубликована?
                </td>
            </tr>';
    echo '</thead>';


    $i=1;//объявляем индекс цикла
    foreach($spisok_novostey as $ocherednaya_novost){
        echo'<tr>';

        echo'<td>';
        echo $i.') ';
        echo'</td>';

        echo'<td>';
        echo '#'.$ocherednaya_novost['id_novosti'];
        echo'</td>';

        echo'<td>';
        echo $ocherednaya_novost['data_vihoda_novosti'];
        echo'</td>';

        echo'<td>';
        echo $ocherednaya_novost['nazvanie_novosti'];
        echo'</td>';

        echo'<td>';
        if($ocherednaya_novost['opublikovana']==1) echo "Да"; else echo "Нет";
        echo'</td>';

        echo'<td>';
        echo '<input type="button" value="Удалить" onclick="return udalit_novost('.$ocherednaya_novost['id_novosti'].');">';
        echo '<input type="button" value="Изменить" onclick="otobrazit_formu_redaktirovamiya_novosti('.$ocherednaya_novost['id_novosti'].');">';
        echo'</td>';

        echo'</tr>';
        $i++;
    }

    echo '</table>';
    echo '<hr>';
} else echo 'Новостей в БД нет';
