/**
 * Created by Максим on 04.11.13.
 * Подключаемый файл с фукциями для блока ЗАКАЗАТЬ
 */

function proverit_formu_autorizatsii(form){
    if(Forma_autorizatsii.login.value == ""){
        alert('Введите логин');
        Forma_autorizatsii.login.focus();
        return false;
    }

    if(!(/^([a-zA-Z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/.test(Forma_autorizatsii.login.value))){
        alert('Некорректный логин. Введите ваш е-мэйл, указанный при регистрации, полностью');
        Forma_autorizatsii.login.focus();
        return false;
    }

    if(Forma_autorizatsii.parol.value == ""){
        alert('Введите пароль');
        Forma_autorizatsii.parol.focus();
        return false;
    }

    if(!(/^[a-zA-Z0-9_-]{3,}$/.test(Forma_autorizatsii.parol.value))){
        alert('Врядли у вас такой пароль. Пароль на нашем сайте не менее трех символов и состоит только из латинских букв и цифр');
        Forma_autorizatsii.parol.focus();
        return false;
    }


    return true;


}

function proveritFormu(form){

    if(Forma_zakaza.sposob_dostavki.value=="0"){
    alert("Не выбран способ доставки");
    Forma_zakaza.sposob_dostavki.focus();
    return false;
    }

    if(Forma_zakaza.sposob_oplati.value=="0"){
    alert("Не выбран способ оплаты");
    Forma_zakaza.sposob_oplati.focus();
    return false;
    }

    if(Forma_zakaza.naimenovanie_pokupatelya.value==""){
    alert("Не указано Имя или Наименование!");
    Forma_zakaza.naimenovanie_pokupatelya.focus();
    return false;
    }

    if(!(/^[a-zA-Zа-яА-Я][ "'`@«»a-zA-Zа-яА-Я0-9-_\.]{2,240}$/.test(Forma_zakaza.naimenovanie_pokupatelya.value))){
    alert("В поле ИМЯ или НАИМЕНОВАНИЕ используйте только буквы, цифры, кавычки и лучше использовать Имя от двух до 240 знаков.");
    Forma_zakaza.naimenovanie_pokupatelya.focus();
    return false;
    }



    if(Forma_zakaza.telephon.value==""){
    alert("Не указан телефон!");
    Forma_zakaza.telephon.focus();
    return false;
    }

    if(!(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,18}$/.test(Forma_zakaza.telephon.value))){
    alert("Для номера телефона используйте только цифры, скобки и тире. В номере минимум семь цифр.");
    Forma_zakaza.telephon.focus();
    return false;
    }





    if(Forma_zakaza.adress_dostavki.value==""){
    alert("Не указан адрес доставки!");
    Forma_zakaza.adress_dostavki.focus();
    return false;
    }


   return true;
}

function proveritFormu_sozdat_uchetnuyu_zapis(form){

    if(Forma_zakaza.email_via_login.value==""){
        alert("Не указан е-мэйл!");
        Forma_zakaza.email_via_login.focus();
        return false;
        }

    if(!(/^([a-zA-Z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/.test(Forma_zakaza.email_via_login.value))){
        alert('Некорректный логин. Используйте ваш е-мэйл для логина.');
        Forma_zakaza.email_via_login.focus();
        return false;
    }


        if(Forma_zakaza.parol.value==""){
        alert("Пароль не может быть пустым!");
        Forma_zakaza.parol.focus();
        return false;
        }

        if(!(/^[a-zA-Z0-9_-]{3,}$/.test(Forma_zakaza.parol.value))){
            alert('Выберите другой пароль. Пароль на нашем сайте не менее трех символов и состоит только из латинских букв и цифр');
            Forma_zakaza.parol.focus();
            return false;
        }


        if(Forma_zakaza.parol.value!==Forma_zakaza.parol2.value){
        alert("Введенные пароли не совпадают!");
        Forma_zakaza.parol.focus();
        return false;
        }
    return true;
}

/*
function ShowHidePoleParol(box){
    var sostoyanie_galochki = (box.checked) ? "block" : "none";
    document.getElementById("div_s_parolem").style.display=sostoyanie_galochki;
}
*/
function changeActionForForm(box){
    if(box.checked){
        document.getElementById("Forma_zakaza").action="/zakazat/sozdat_uchetnuyu_zapis.php";

    }
    else {
        document.getElementById("Forma_zakaza").action="/zakazat/sohranit_zakaz.php";

    }
}
