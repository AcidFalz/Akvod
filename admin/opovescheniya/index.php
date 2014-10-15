<?php
/* Скрипт-часть для редактирования настроек оповещения админа о новом заказе
  */
/* Массив имеет такие поля
         $_SESSION['dannie_o_admine'] = array(
                `id_admina`,
                `imya_admina`,
                `login`,
                `parol`,
                `e-mail`
                `telephon`
                `uvedomlyat_na_telephon`
                `uvedomlyat_na_email`
                 )
*/

//Стартуем сессию
session_start();

//Получаем данные о залогиненном менеджере
$dannie_o_admine = $_SESSION['dannie_o_admine'];


echo '<form name="forma_nastroyki_opovescheniy" class="forma_v_adminke">
        <strong class="zagolovok_bloka">Настройки оповещения менеджера о поступлении нового заказа. <br>(Менеджер -- это вы)</strong>

        <ul>
            <li>';
echo '                <input type="checkbox" name="na_telephon" '.$dannie_o_admine['uvedomlyat_na_telephon'].'>';
echo '               Оповещать на телефон по смс (пока не реализовано)
            </li>
            <li>';
echo '                <input type="checkbox" name="na_email" '.$dannie_o_admine['uvedomlyat_na_email'].'>';
echo '                Оповещать на е-мэйл

            </li>
            <li>
                <input type="button" value="Сохранить" onclick="sohranit_nastroyki();">
            </li>

        </ul>
      </form>';

