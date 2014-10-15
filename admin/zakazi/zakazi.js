/**
Содержит скрипты для страницы Заказы
 */

//Вызывать так:
// vibrat_dannie(number id_pokupatelya|ALL, string data_zakaza|ALL, number id_statusa_zakaza|ALL);
function vibrat_dannie(form){

    //Получаем данные для запроса
    var data_zakaza = Forma_s_filtrami.Select_s_datoy.value;
    var id_pokupatelya = Forma_s_filtrami.Select_s_naimenovaniem_pokupatelya.value;
    var id_statusa_zakaza = Forma_s_filtrami.Select_so_statusami.value;

    //Создаем экземпляр XMLHttpRequet
    var XMLHttp = sozdat_object_XMLHttpRequest();

    //Формируем запрос
    var zapros = "/admin/zakazi/vibrat_dannie.php?"
                    +"id_pokupatelya="+id_pokupatelya
                    +"&data_zakaza="+data_zakaza
                    +"&id_statusa_zakaza="+id_statusa_zakaza;

    //Открываем соединение и отправить запрос
    XMLHttp.open("GET", zapros, false);
    XMLHttp.send(null);

    //Обрабатываем ответ
    if(XMLHttp.status == 200){
        document.getElementById('rezultati_zaprosa_vivodit_syuda').innerHTML=XMLHttp.response;
    }else document.getElementById('rezultati_zaprosa_vivodit_syuda').innerHTML="Ошибка запроса к БД";

}

//Функция отображения состава заказа во всплывающем окне
function posmotret_zakaz(nomer_zakaza){
    //Все как обычно: создаем, формируем, открывает и отправляем. Затем обрабатываем ответ.
    var XMLHttp = sozdat_object_XMLHttpRequest();
    var zapros="/admin/zakazi/posmotret_zakaz.php?n="+nomer_zakaza;
    XMLHttp.open("GET",zapros,false);
    XMLHttp.send(null);
    if(XMLHttp.status == 200){
        document.getElementById('vsplivayuschee_okno').style.display="block";
        document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML=XMLHttp.response;
    }else {
        document.getElementById('vsplivayuschee_okno').style.display="block";
        document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML="Ошибка запроса состава заказа";
    }

}


//Функция отображения формы редактирования статуса заказа во всплывающем окне
function otobrazit_formu_redaktirovamiya_statusa_zakaza(nomer_zakaza){
    //Все как обычно: создаем, формируем, открывает и отправляем. Затем обрабатываем ответ.
    var XMLHttp = sozdat_object_XMLHttpRequest();
    var zapros="/admin/zakazi/otobrazit_formu_redaktirovamiya_statusa_zakaza.php?n="+nomer_zakaza;
    XMLHttp.open("GET",zapros,false);
    XMLHttp.send(null);
    if(XMLHttp.status == 200){
        document.getElementById('vsplivayuschee_okno').style.display="block";
        document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML=XMLHttp.response;
    }else {
        document.getElementById('vsplivayuschee_okno').style.display="block";
        document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML="Ошибка запроса статуса заказа";
    }

}

//Функция вызова скрипта сохранения измененного статуса заказа
function izmenit_status_zakaza(form){
    //Все как обычно: создаем, формируем, открывает и отправляем. Затем обрабатываем ответ.
    var XMLHttp = sozdat_object_XMLHttpRequest();
    var zapros="/admin/zakazi/izmenit_status_zakaza.php?n="
                +Forma_redaktirovaniya_statusa.nomer_zakaza.value
                +"&s="
                +Forma_redaktirovaniya_statusa.Select_so_statusami.value
                +"&comm="
                +Forma_redaktirovaniya_statusa.commentariy.value;

    XMLHttp.open("GET",zapros,false);
    XMLHttp.send(null);
    if(XMLHttp.status == 200){
        if(XMLHttp.response != ""){
            document.getElementById('mesto_v_okne_dlya_vivoda').innerHTML=XMLHttp.response;
        }else {
            document.getElementById('vsplivayuschee_okno').style.display='none';
            vibrat_dannie();
        }
    }else {
        alert('Ошибка сохранения статуса заказа');
        otobrazit_formu_redaktirovamiya_statusa_zakaza(Forma_redaktirovaniya_statusa.nomer_zakaza.value);
    }
return true;
}