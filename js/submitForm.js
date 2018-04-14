function submitLog(form) {
    resetError();
    validate(form);
    //если нет ошибок
    if ($('.error').length == 0) {
        var login = $('#loginLog').val();
        var password = $('#passwordLog').val();
        //отправка данных на сервер
        $.ajax({
            type: "POST",
            url: "./login/login.php",
            data: {login:login, password:password},
            success: function(data) {
                //в случае успешного ответа от сервера
                var obj = $.parseJSON(data);
                if (obj.error) {
                    showError(nextElem(obj.elem), obj.error);
                } else {
                    welcome(obj.user);
                }
            }
        })
    }
}

function submitReg(form) {
    resetError();
    validate(form);
    //если нет ошибок
    if ($('.error').length == 0) {
        var login = $('#loginReg').val();
        var password = $('#passwordReg').val();
        var confirm = $('#confirmReg').val();
        var email = $('#emailReg').val();
        var name = $('#nameReg').val();
        //отправка данных на сервер
        $.ajax({
            type: "POST",
            url: "./register/register.php",
            data: {login:login, password:password, confirm:confirm, email:email, name:name},
            success: function(data) {
                //в случае успешного ответа от сервера
                var obj = $.parseJSON(data);
                if (obj.error) {
                    showError(nextElem(obj.elem), obj.error);
                } else {
                    welcome(obj.user);
                }
            }
        })
    }
}

function validate(form) {
    var elems = form.getElementsByTagName('input');
    for (var i = 0; i < elems.length; i++) {
        if (elems[i].value == "") {
            showError(elems[i + 1], "This field cannot be empty.");
        }
    }
}

function showError(nextElem, message) {
    var container = document.createElement("span");
    container.className = "error";
    container.innerHTML = message;
    parent = nextElem.parentNode;
    parent.insertBefore(container, nextElem);
}

function resetError() {
    $('.error').remove();
}

function nextElem(id) {
    var elems = document.getElementsByTagName('input');
    for (var i = 0; i < elems.length; i++) {
        if (elems[i].id == id) {
            var nextElem = elems[i + 1];
        }
    }
    return nextElem;
}

function welcome(user) {
    $('#modalLog').css('display', 'none');
    $('#modalReg').css('display', 'none');
    $('.reg-links').css('visibility', 'hidden');
    $('.welcome').css('display', 'block');
    $('#user').text('Hello, ' + user);
}