/**
Содержит функции для обесчения раздела Товары */


// Функция отображения окна с формой редактирования товара
function otobrazit_formu_redaktirovamiya_tovara(id_tovara){
    document.getElementById('vsplivayuschee_okno').style.display='block';
    var XMLHttp=sozdat_object_XMLHttpRequest();
    var zapros="/admin/tovari/forma_redactiromaniya_tovara.php";
    if(typeof id_tovara === "number") zapros+="?id_tovara="+id_tovara;
    XMLHttp.open("GET", zapros, false);
    XMLHttp.send(null);

    if(XMLHttp.status == 200){
        document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML=XMLHttp.response;
    } else document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML="Ошибка вывода формы редактирования";

}

// Функция вызова скрипта сохранения изменений по товару или созданию товара
function sohrahit_tovar(form, deystvie){

    var XMLHttp = sozdat_object_XMLHttpRequest();
    var zapros="/admin/tovari/sohranit_tovar.php?id_tovara=";
        if(deystvie == "sohranit") zapros+=Forma.id_tovara.value;
        zapros+="&nazvanie_tovara="
                +Forma.nazvanie_tovara.value
                +"&link_na_small_kartinku="
                +Forma.link_na_small_kartinku.value
                +"&tsena="
                +Forma.tsena.value
                +"&nalichie_na_sklade="
                +Forma.nalichie_na_sklade.value
                +"&opisanie_tovara="
                +Forma.opisanie_tovara.value
                +"&deystvie="+deystvie;

    XMLHttp.open("GET",zapros,false);
    XMLHttp.send(null);


    if(XMLHttp.status == 200){
        if(XMLHttp.response == ""){
            Smenit_punkt_menu(4,'Товары', '/admin/tovari/index.php');
        }else document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML=XMLHttp.response;
    }else document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML="Ошибка сохранения заказа";


}



