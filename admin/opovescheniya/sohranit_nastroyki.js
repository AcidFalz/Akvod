/**
Скрипт, относящийся к части "оповещения менеджера о новом заказе"
 вызывает скрипт sohranit_nastroyki.PHP для сохранения настроек в БД
 */

function sohranit_nastroyki(form){

    //Создать экземпляр объекта XMLHttpRequest
    var XMLHttp = sozdat_object_XMLHttpRequest();

    //Составить запрос
    var zapros = "/admin/opovescheniya/sohranit_nastroyki.php?po_sms=";
    zapros += forma_nastroyki_opovescheniy.na_telephon.checked;
    zapros += "&po_e=";
    zapros += forma_nastroyki_opovescheniy.na_email.checked;

    //Открываем соединение
    XMLHttp.open("GET", zapros, false);

    //Отправляем запрос
    XMLHttp.send(null);

    //Проверяем статус ответа
    if(XMLHttp.status == 200){
        document.getElementById("yacheyka_vyvoda_stranitsi_id").innerHTML=XMLHttp.response;
    } else {
        document.getElementById("yacheyka_vyvoda_stranitsi_id").innerHTML="Ошибка сохранения данных в БД";
    }




}