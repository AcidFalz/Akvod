<?php
/** Титульный скрипт админ страницы */




/*
 * Общие переменные
 * $_SESSION['dostupnie_punkti_menu'] = array (
            nomer_punkta_menu =>
            nazvanie_punkta_menu =>
            podskazka_k_punktu =>
            link_na_script =>
            )
 */





/*Стартовые объявления:
    Показываем ошибки,
    стартуем сесию,
    проверяем залогинен ли,
    поключаем БД
    и выбираем необходимые данные.*/
include "../admin/chasti_titula/10_startovie_obyavleniya_chast.php";


//Выводим Страницу

//Шапка и подключение файла с JavaScript
include "../admin/chasti_titula/20_shapka_chast.php";

//Строка навигации
include "../admin/chasti_titula/30_stroka_navigatsii_chast.php";

//Панель меню
include "../admin/chasti_titula/40_panel_menu_chast.php";

//Панель вывода
include "../admin/chasti_titula/50_panel_vivoda_chast.php";

//Подвал
include "../admin/chasti_titula/60_podval_chast.php";