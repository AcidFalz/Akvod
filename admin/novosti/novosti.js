/* Содержит функции для обеспечения раздела новости
 */

// Функция отображения окна с формой редактирования новости
function otobrazit_formu_redaktirovamiya_novosti(id_novosti){
    document.getElementById('vsplivayuschee_okno').style.display='block';
    var XMLHttp=sozdat_object_XMLHttpRequest();
    var zapros="/admin/novosti/forma_redactirovaniya_novosti.php";
    if(typeof id_novosti === "number") zapros+="?id_novosti="+id_novosti;
    XMLHttp.open("GET", zapros, false);
    XMLHttp.send(null);

    if(XMLHttp.status == 200){
        document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML=XMLHttp.response;
    } else document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML="Ошибка вывода формы редактирования новости";

}

// Функция вызова скрипта сохранения изменений по новости или созданию новости
function sohrahit_novost(form, deystvie){

   // alert(Forma.miniatyura_img.value);

    var XMLHttp = sozdat_object_XMLHttpRequest();
    var zapros="/admin/novosti/sohranit_novost.php?id_novosti=";
        if(deystvie == "sohranit") zapros+=Forma.id_novosti.value;
        zapros+="&data_vihoda_novosti="
                +Forma.data_vihoda_novosti.value
                +"&nazvanie_novosti="
                +Forma.nazvanie_novosti.value
                +"&anons_of_a_new="
                +Forma.anons_of_a_new.value
                +"&path_to_a_new="
                +Forma.path_to_a_new.value
                +"&miniatyura_img="
                +Forma.miniatyura_img.value
                +"&opublikovana="
                +Forma.opublikovana.value
                +"&deystvie="+deystvie
                +"&razoslat="
                +Forma.razoslat.checked;

    XMLHttp.open("POST",zapros,false);
    XMLHttp.send(null);


    if(XMLHttp.status == 200){
        if(XMLHttp.response == ""){
            //alert('Новость успешно сохранена');
            Smenit_punkt_menu(5,'Новости', '/admin/novosti/index.php');
        }else document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML=XMLHttp.response;
    }else document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML='Ошибка сохранения новости.<br> Вероятно размер анонса новости превышает 2Кб.<br><input type="button" value="Закрыть" onclick="document.getElementById(\'vsplivayuschee_okno\').style.display=\'none\'">';


}

function udalit_novost(id_novosti){
    if(confirm('Действительно удалить эту новость?')){
    var XMLHttp = sozdat_object_XMLHttpRequest();
    var zapros = "/admin/novosti/udalit_novost.php?id_novosti="+id_novosti;
    XMLHttp.open("GET", zapros, false);
    XMLHttp.send(null);

    if(XMLHttp.status == 200){
          if(XMLHttp.response == ""){
              //alert('Новость успешно удалена');
              Smenit_punkt_menu(5,'Новости', '/admin/novosti/index.php');
              }else {
                      document.getElementById('vsplivayuschee_okno').style.display='block';
                      document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML=XMLHttp.response+'<br><input type="button" value="Закрыть" onclick="document.getElementById(\'vsplivayuschee_okno\').style.display=\'none\'">';
                    }
    }else {
            document.getElementById('vsplivayuschee_okno').style.display='block';
            document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML='Ошибка удаления новости.<br><input type="button" value="Закрыть" onclick="document.getElementById(\'vsplivayuschee_okno\').style.display=\'none\'">';
          }
    return true;

} else return false;



}

