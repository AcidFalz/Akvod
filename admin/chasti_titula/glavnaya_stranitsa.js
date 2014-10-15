/**
 * содержит функции для выбора пункта меню
 */

    //Функция для создания экземпляра объекта XMLHttpRequest
function sozdat_object_XMLHttpRequest(){

    if (typeof XMLHttpRequest === 'undefined') {
        XMLHttpRequest = function() {
          try { return new ActiveXObject("Msxml2.XMLHTTP.6.0"); }
            catch(e) {}
          try { return new ActiveXObject("Msxml2.XMLHTTP.3.0"); }
            catch(e) {}
          try { return new ActiveXObject("Msxml2.XMLHTTP"); }
            catch(e) {}
          try { return new ActiveXObject("Microsoft.XMLHTTP"); }
            catch(e) {}
          throw new Error("This browser does not support XMLHttpRequest.");
        };
      }
      return new XMLHttpRequest();
}




//Функция переключения титульной страницы на другой пункт меню
function Smenit_punkt_menu(nomer_punkta, nazvanie_punkta, link_na_script){

    //Перед изменением возвращаем св-ва к первоначальным
    var punkti = document.getElementsByClassName("punkt_menu");
    for(var i=0; i<punkti.length; i++){
        if(punkti[i].style.borderBottomColor="green"){
            punkti[i].style.borderBottomColor="white";
            punkti[i].style.cursor="pointer";
            punkti[i].style.background="white";
        }
    }

    //Убрать ссылку на себя и выделить маркетом пункт меню
    var id_punkta = "punkt_menu_nomer_"+nomer_punkta;

    var punkt=document.getElementById(id_punkta);
    punkt.style.borderBottomColor="green";
    punkt.style.cursor="default";
    punkt.style.backgroundColor="lightgrey";




    //Изменить строку навигации
    document.getElementById("izmenyaemiy_punkt_stroki_navigatsii").textContent=nazvanie_punkta;



    //Подключить целевой скрипт

    //Создаем экземпляр объекта
    var XMLHttp=sozdat_object_XMLHttpRequest();

    //ФОрмируем запрос
    var zapros=link_na_script;

    //Открываем соединение используя запрос
    XMLHttp.open("GET", zapros, false);

    //Отправляем запрос
    XMLHttp.send(null);

    //Формируем текст ответа и вставляем в Ячейку вывода целевой страницы
    if(XMLHttp.status == 200){

       document.getElementById("yacheyka_vyvoda_stranitsi_id").innerHTML = XMLHttp.response;
    } else {

        document.getElementById("yacheyka_vyvoda_stranitsi_id").innerText = "Ошибка загрузки нужной страницы";
    }






}

