<?php
/* Скрипт-часть админ страницы про Товары.
    Содердит ссылки на "Добавить товар", "Редактиовать товар",
*/

//Подключаем БД
include ("../../db/db_connect.php");//подключаем файл с параметрами соединения
$connection=mysql_connect($db_host, $db_username, $db_password); //устанавливаем соединение
if(!$connection){die("Нельзя подключиться к БД: <br />".mysql_error());}//проверяем, установлено ли?
$db_select=mysql_select_db($db_database);//выбираем БД
if(!$db_select){die("База не выбралась: <br />".mysql_error());}//проверяем выбралась ли


//Составляем и выбираем перечень товаров
$query ="SELECT * FROM `Tovari_table`";

//Выполняем запрос
$rezult=mysql_query($query);
if(!$rezult){echo 'Ошибка выборки списка товаров<br>'.mysql_error(); exit;}

//Сохраняем результат
$kolichestvo_tovarov = mysql_num_rows($rezult);
for($i=0; $i<$kolichestvo_tovarov; $i++){
    $spisok_tovarov[]=mysql_fetch_array($rezult,MYSQL_ASSOC);
}

/* В итоге в массиве содержатся такие поля
    $spisok_tovarov = array (
                `id_tovara`,
                `nazvanie_tovara`,
                `link_na_small_kartinku`,
                `tsena`,
                `nalichie_na_sklade`,
                `opisanie_tovara`
                )
*/

//Закрываем соединение с БД
mysql_close();



//Сразу создаем всплывающее окно для отображения состава заказа и редактирования заказа
echo '<ul id="vsplivayuschee_okno">
        <span id="mesto_v_okne_dlya_vivoda"></span>
      </ul>';

echo '<input type="button" value="Создать товар" onclick="otobrazit_formu_redaktirovamiya_tovara();">';
if(isset($spisok_tovarov)) {

    echo '<table>';

    echo '<caption class="strong">Список товаров</caption>';
    echo '<thead>';
    echo '  <tr>
                <td>
                    <nobr>п/п</nobr>
                </td>
               <td>
                    #id товара
                </td>
                <td>
                    Название
                </td>
               <td>
                    Цена
                </td>
                <td>
                    Наличие на складе
                </td>
                <td>

                </td>
            </tr>';
    echo '</thead>';


    $i=1;//объявляем индекс цикла
    foreach($spisok_tovarov as $ocherednoy_tovar){
        echo'<tr>';

        echo'<td>';
        echo $i.') ';
        echo'</td>';

        echo'<td>';
        echo '#'.$ocherednoy_tovar['id_tovara'];
        echo'</td>';

        echo'<td>';
        echo $ocherednoy_tovar['nazvanie_tovara'];
        echo'</td>';

        echo'<td>';
        echo $ocherednoy_tovar['tsena'].' грн за ед.';
        echo'</td>';

        echo'<td>';
        if($ocherednoy_tovar['nalichie_na_sklade']==1) echo "Есть"; else echo "Нет";
        echo'</td>';

        echo'<td>';
        //echo '<input type="button" value="Удалить" onclick="udalit_tovar('.$ocherednoy_tovar['id_tovara'].');">';
        echo '<input type="button" value="Изменить" onclick="otobrazit_formu_redaktirovamiya_tovara('.$ocherednoy_tovar['id_tovara'].');">';
        echo'</td>';

        echo'</tr>';
        $i++;
    }

    echo '</table>';
    echo '<hr>';
} else echo 'Товаров в БД нет';