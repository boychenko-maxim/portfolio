<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Вход</title>
    <style>
        form {
            width: 350px;
        }

        input {
            margin-bottom: 5px;
        }

        input[type=text], input[type=password] {
            border: 1px solid black;
        }

        input[type=text]:focus, input[type=password]:focus {
            border: 1px solid blue;
        }

        input[type=text].error, input[type=password].error {
            border-color: red;
        }

        #loginResult, .errorText {
            font-size: small;
            color: red;
            margin-bottom: 5px;
        }
        form span {
            display: inline-block;
            margin-bottom: 3px;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(function () {
            $('#loginForm').submit(function (event) {
                event.preventDefault();

                $('#loginResult').text("");

                $('#login').trigger("blur");
                $('#password').trigger('blur');

                if (!$('#login').hasClass('error') && !$('#password').hasClass('error')) {
                    $.ajax({
                        type: 'POST',
                        url: '/users-sign-up/login/canLogin',
                        data: $(this).serialize()
                    }).done(function (data) {
                        var canLogin = data == 'true';
                        if (canLogin) {
                            window.location.replace('user');
                        } else {
                            $('#loginResult').text("Неверный логин или пароль!");
                        }
                    });
                }
            })
        });
    </script>
</head>
<body>
<div>
    <a href="..">Портфолио</a> &bull; <a href="#">MVC</a>
    <hr>
</div>
<form id="loginForm">
    <span>Логин:</span><br>
    <input id="login" type="text" name="userLogin" autocomplete="off">
    <div id="loginError" class="errorText"></div>

    <span>Пароль:</span><br>
    <input id="password" type="password" name="userPassword">
    <div id="passwordError" class="errorText"></div>

    <input type="submit" value="Войти">
    <span id="loginResult"></span>
</form>
<form action="registration">
    <input type="submit" value="Регистрация">
</form>

<script>
    login.onblur = function () {
        if (isEmpty(this, loginError)) {
            return;
        }

        if (!((/^\s*[a-z0-9]*\s*$/i).test(this.value.trim()))) {
            this.className = 'error';
            loginError.innerText = "Логин должен состоять их латинских букв и цифр";
        }
    };

    login.onfocus = function () {
        dropError(this, loginError);
    }

    password.onblur = function () {
        isEmpty(this, passwordError);
    };

    password.onfocus = function () {
        dropError(this, passwordError);
    }

    function isEmpty(input, error) {
        if (input.value.trim().length == 0) {
            input.className = "error";
            error.innerHTML = 'Это поле должно быть заполнено';
            return true;
        }
        return false;
    }

    function dropError(input, error) {
        if (input.className == 'error') { // сбросить состояние "ошибка", если оно есть
            input.className = "";
            error.innerHTML = "";
        }
    }
</script>
</body>
</html>