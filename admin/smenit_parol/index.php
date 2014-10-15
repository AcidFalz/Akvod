<?php

/* Составной скрипт смены пароля администратора

*/
session_start();


    echo '<table><tr>
    <td class="yacheyka_s_formoy" id="pole_vivoda_smena_parolya">
       <form name="Forma_smeni_parolya" class="forma_v_adminke">
        <strong class="zagolovok_bloka">Смена пароля</strong>
        <span class="pole_formi_s_nadpisyu">
            Введите старый пароль<br>
            <input type="password" name="Stariy_parol"><br>
        </span>

        <span class="pole_formi_s_nadpisyu">
            Введите новый пароль<br>
            <input type="password" name="Noviy_parol"><br>
        </span>

        <span class="pole_formi_s_nadpisyu">
            Введите новый пароль ещё раз<br>
            <input type="password" name="Noviy_parol_povtor"><br>
        </span>
        <input type="button" value="Сменить пароль" onclick="proverit_parol_i_smenit();">
      </form>
    </td>

    <td class="yacheyka_s_formoy" id="pole_vivoda_smena_telephona_emeyla">
        <form name="Forma_smeni_telephona_i_emeila" class="forma_v_adminke">
            <strong class="zagolovok_bloka">Редактирование телефона и е-мэйла</strong>
            <table><tr>
            <td class="pole_formi_s_nadpisyu">
                Телефон<br>';
echo'                <input type="tel" name="telephon" value="'.$_SESSION['dannie_o_admine']['telephon'].'"><br>';
echo'            </td>
            <td class="pole_formi_s_nadpisyu">
                Е-мэйл<br>';
echo'                <input type="email" name="email" value="'.$_SESSION['e-mail'].'" size="20">';
echo'            </td>
            </tr></table>
           <input type="button" value="Сохранить" class="knopka_sohranit" onclick="return proverit_formu_smeni_telephona_i_emaila();">
        </form>
    </td>
    </tr></table>


    ';

