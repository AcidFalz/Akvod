<?php
/*<!-- Блок кода для вставки в другой скрипт
В блоке часть кода для отображения формы авторизации

Используемые переменные
Читает переменные:
$_SESSION['id_pokupatelya']
$_SESSION['naimenovanie_pokupatelya']
$_GET['oshinka_avtorizatsii']

Записывает переменные:
$_POST['login']
$_POST['parol']
$_POST['otsovskaya_stranitsa']

-->
*/







/*
2)	Проверяем авторизирован ли пользователь,
Если ДА, то устанавливаем флаг “zalogonen”=YES,
Иначе устанавливаем флаг “zalogonen”=NO.
 */

if(isset($_SESSION['id_pokupatelya'])){
    $zaloginen = 1;
}
else{
    $zaloginen = 0;
}





/* 5)	Отображаем блок авторизации
            Если “zalogonen”, то ИМЯ_ПОЛЬЗОВАТЕЛЯ и ссылку в личный кабинет.
            Если НЕ “zalogonen”, то форму ввода логина/пароля, ссылку на скрипт регистрации,
            также сохраняем линк скрипта на сам себя в переменной сессии “otsovskaya_stranitsa”
             */

            if($zaloginen) { //Если “zalogonen”, то ИМЯ_ПОЛЬЗОВАТЕЛЯ и ссылку в личный кабинет.
                echo '<dir  class="forma_avtorizatsii">
                <a href="/lichniy_kabinet/">'.
                $_SESSION['naimenovanie_pokupatelya'].
                '</a>'.
                ', '.
                ' '.
                '<a href="/lichniy_kabinet/viyti.php?otsovskaya_stranitsa='.$_SERVER['PHP_SELF'].'">выйти</a>
                </dir>
                ';
            }
            elseif(!$zaloginen){ //Если НЕ “zalogonen”, то отображаем форму ввода логина/пароля

                echo '        <script type="text/javascript" src="zakazat.js"></script>';
                echo '        <form name="Forma_autorizatsii" id="Forma_autorizatsii" action="/zakazat/priznat.php" method="post"  class="forma_avtorizatsii" onsubmit="return proverit_formu_autorizatsii(this)">';
                echo '          <table border="0" cellpadding="1" cellspacing="0">';
                echo '        <tr><td>Логин</td>';
                echo '        <td>Пароль</td></tr>';
                echo '        <tr><td><input type="text" width="10" name="login"></td>';
                echo '        <td><input type="password" width="10" name="parol"></td>';

                echo '       <input type="hidden" name="otsovskaya_stranitsa" value="'.$_SERVER['PHP_SELF'].'">';

                echo '        <td><input type="submit" value="вход"></td></tr>';
                echo '          </table>';
                echo '        ';
                if(isset($_GET['oshinka_avtorizatsii']))
                {   echo '<span>'.$_GET['oshinka_avtorizatsii'];
                    if($_GET['oshinka_avtorizatsii']=='Неверный логин или пароль'){
                         echo '<a href="../vosstanovit_parol/index.php"> Восстановить пароль</a>';
                         }
                    echo '</span>';
                }
                echo '</form>';
            }

?>