/**
 * Created with JetBrains PhpStorm.
 * User: Максим
 * Date: 07.10.13
 * Time: 21:29
 * To change this template use File | Settings | File Templates.
 */

function proverit_parol_i_smenit (form){

   if(Forma_smeni_parolya.Stariy_parol.value == ""){
       alert("Введите старый пароль");
   }else if(Forma_smeni_parolya.Noviy_parol.value == ""){
       alert("Введите новый пароль");
   }else if(Forma_smeni_parolya.Noviy_parol_povtor.value == ""){
       alert("Введите новый пароль ещё раз");
   }else if(Forma_smeni_parolya.Noviy_parol.value != Forma_smeni_parolya.Noviy_parol_povtor.value){
       alert("Введенные новые пароли не совпадают");
   } else {
        //Если форма заполнена верно, то вызываем скрипт смены пароля

       //Просим подождать
      // var message=document.createTextNode("Пожалуйста подождите, обрабатывается запрос ...");
      // document.getElementsByName("yacheyka_vyvoda_menu").appendChild(message);


       var XMLHttp=sozdat_object_XMLHttpRequest();


       var zapros="/admin/smenit_parol/smenit_parol.php?sp=";
       zapros += Forma_smeni_parolya.Stariy_parol.value;
       zapros += "&np=";
       zapros += Forma_smeni_parolya.Noviy_parol.value;


       XMLHttp.open("GET", zapros, false);

       XMLHttp.send(null);

       if(XMLHttp.status == 200){
           document.getElementById("pole_vivoda_smena_parolya").innerHTML=XMLHttp.response;
       } else {
           document.getElementById("pole_vivoda_smena_parolya").innerText="Ошибка смены пароля";
       }


   }

}

function proverit_formu_smeni_telephona_i_emaila (){

        if(Forma_smeni_telephona_i_emeila.telephon.value==""){
            alert("Не указан телефон!");
            Forma_smeni_telephona_i_emeila.telephon.focus();
            return false;
        }

        if(!(/^((8|\+38)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,18}$/.test(Forma_smeni_telephona_i_emeila.telephon.value))){
            alert("Для номера телефона используйте только цифры, скобки и тире. В номере минимум семь цифр. Например: (091) 114-23-77 или 234-34-56");
            Forma_smeni_telephona_i_emeila.telephon.focus();
            return false;
        }

        if(Forma_smeni_telephona_i_emeila.email.value==""){
            alert("Не указан е-мэйл!");
            Forma_smeni_telephona_i_emeila.email.focus();
            return false;
        }

        if(!(/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/.test(Forma_smeni_telephona_i_emeila.email.value))){
            alert('Некорректный логин. Используйте ваш е-мэйл для логина.');
            Forma_smeni_telephona_i_emeila.email.focus();
            return false;
        }

    //Если все нормально, то вызываем ф-цию смены телефона и е-мэйла
    smenit_telephon_i_email();

    return true;
}

//Сменить телефон и е-мэйл
function smenit_telephon_i_email(form) {

    //Создаем экземпляр XMLHttpRequest
    var XMLHttp=sozdat_object_XMLHttpRequest();

    //Формируем запрос
    var zapros = "/admin/smenit_parol/smenit_telephon_i_email.php?t=";
        zapros += Forma_smeni_telephona_i_emeila.telephon.value;
        zapros += "&e=";
        zapros += Forma_smeni_telephona_i_emeila.email.value;

    //Отрываем соединение
    XMLHttp.open("GET",zapros,false);

    //Отправляем запрос
    XMLHttp.send(null);

    //Обрабатываем ответ
    if(XMLHttp.status == 200){
        document.getElementById('pole_vivoda_smena_telephona_emeyla').innerHTML=XMLHttp.response;
    } else {
        document.getElementById('pole_vivoda_smena_telephona_emeyla').innerText="Ошибка обращения к скрипту";
    }


}