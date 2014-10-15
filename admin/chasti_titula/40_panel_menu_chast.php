<?php
/* Формирование и вывод панели меню

$_SESSION['dostupnie_punkti_menu'] = array ( //заполняется в скрипте /admin/chasti_titula/10_startovie_obyavleniya_chast.php
            nomer_punkta_menu =>
            nazvanie_punkta_menu =>
            podskazka_k_punktu =>
            link_na_script =>
            )

*/

//Открываем таблицу, строку и ячейку с панелью меню
echo '<table id="titulnaya_tablitsa">
    <tr>
        <td title="" id="yacheyka_vyvoda_menu">
';


echo '  <table>';

foreach($_SESSION['dostupnie_punkti_menu'] as $ocherednoy_punkt){

echo '     <tr>';
echo '         <td id="punkt_menu_nomer_'.$ocherednoy_punkt['nomer_punkta_menu'].'" class="punkt_menu">';
echo '             <span title="'.$ocherednoy_punkt['podskazka_k_punktu'].'"
                        onclick="Smenit_punkt_menu('.$ocherednoy_punkt['nomer_punkta_menu'].',
                         \''.$ocherednoy_punkt['nazvanie_punkta_menu'].'\', \''.$ocherednoy_punkt['link_na_script'].'\')">';
echo                   $ocherednoy_punkt['nazvanie_punkta_menu'];
echo '             </span>';
echo '         </td>';
echo '    </tr>';

}

echo '  </table>';


//Закрываем ячейку с пенелью меню. Строка и таблица за крывается в другой части.
echo   '</td>
';