/**
 * Created by Максим on 06.11.13.
 * Поключаемый файл с функциями для блока заказать
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




function vnesti_zapis(){

        if(document.getElementById("pole_vvoda").value == ""){
            alert("Введите ваш е-мэйл");
            document.getElementById("pole_vvoda").focus();
            return false;
        }

        if(!(/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/.test(document.getElementById("pole_vvoda").value))){
            alert('Некорректный е-мэйл. Используйте ваш е-мэйл, чтобы подписаться на новости.');
            document.getElementById("pole_vvoda").focus();
            return false;
        }

        //Получаем содержимое поля ввода
        var email= document.getElementById("pole_vvoda").value;

        //Создаем экземпляр объекта
        var XMLHttp=sozdat_object_XMLHttpRequest();

        //ФОрмируем запрос
        var zapros = "vnesti_zapis.php?email=";
            zapros+= email;


        //Открываем соединение используя запрос
        XMLHttp.open("GET", zapros, false);

        //Отправляем запрос
        XMLHttp.send(null);


        //Формируем текст ответа
        if (XMLHttp.status == 200){ // 200 значит "ОК"
            //Добавляем к содержимому формы текс ответа
            document.getElementById('forma_vvoda').innerHTML = XMLHttp.response;

        } else { //Если не 200, значит что-то с ответом не так,
            // пишем в форму "Ошибка вставки е-мэйла в список рассылки"
            document.getElementById('forma_vvoda').innerHTML = "Ошибка вставки е-мэйла в список рассылки";

    }
    return true;

}


//функция вызова скрипта для восстановления пароля
function napomnit(){

        //Получаем содержимое поля ввода
        var email= document.getElementById("pole_vvoda").value;

        if (email.length == 0){
            alert("Введите Ваш е-мэйл");
            document.getElementById("pole_vvoda").focus();
            return false;
        }

        if(!(/^([A-Za-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/.test(document.getElementById("pole_vvoda").value))){
             alert('Некорректный е-мэйл. При регистрации вы использовали ваш е-мэйл.');
             document.getElementById("pole_vvoda").focus();
             return false;
         }


        //Создаем экземпляр объекта
        var XMLHttp=sozdat_object_XMLHttpRequest();

        //ФОрмируем запрос
        var zapros = "vosstanovit_i_soobshit.php?email=";
            zapros+= email;


        //Открываем соединение используя запрос
        XMLHttp.open("GET", zapros, false);

        //Отправляем запрос
        XMLHttp.send(null);


        //Формируем текст ответа
        if (XMLHttp.status == 200){ // 200 значит "ОК"
            //Добавляем к содержимому формы текс ответа
            document.getElementById('forma_vvoda').innerHTML = XMLHttp.response;

        } else { //Если не 200, значит что-то с ответом не так,
            // пишем в форму "Ошибка вставки е-мэйла в список рассылки"
            document.getElementById('forma_vvoda').innerHTML = "Ошибка проверки е-мэйла";

    }
return true;

}



//Функция для отображения состава заказа во всплывающем окне
function Pokazat_Sostav_Zakaza(z){

    //Создаем экземпляр объекта
    var XHR=sozdat_object_XMLHttpRequest();


    //ФОрмируем запрос
    var zapros="/lichniy_kabinet/poluchit_sostav_zakaza.php?z=";
    zapros+=z;


    //Открываем соединение используя запрос
    XHR.open("GET", zapros, false);

    //Отправляем запрос
    XHR.send(null);

    //Формируем текст ответа
    if (XHR.status == 200){ // 200 значит "ОК"
        //Добавляем к содержимому окна DIV текс ответа, содержащий состав заказа
        document.getElementById('mesto_vstavki_sostava_zakaza').innerHTML = XHR.response;

    } else { //Если не 200, значит что-то с ответом не так,
        // пишем в окно DIV "Ошибка загрузки состава заказа"
        document.getElementById('mesto_vstavki_sostava_zakaza').innerHTML = "Ошибка загрузки состава заказа";

    }

    //Отображаем DIV Окно
    document.getElementById('divokno').style.display='block';




}


