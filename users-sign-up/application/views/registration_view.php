<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Регистрация</title>
    <style>
        form {
            width: 215px;
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

        #error, .errorText {
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
            $('#registrationForm').submit(function (event) {
                event.preventDefault();

                if (registrationClientValidation()) {
                    $.ajax({
                        type: 'POST',
                        url: '/users-sign-up/registration/canRegister',
                        data: $(this).serialize()
                    }).done(function(data){
                        var canRegister = data == 'true';
                        if (canRegister) {
                            window.location.replace('user');
                        } else {
                            $('#error').text("Пользователь с таким именем уже существует!");
                            $('#login').attr('class', 'error');
                        }
                    });
                }
            })
        });

        function registrationClientValidation() {
            $('#login').trigger("blur");
            $('#age').trigger('blur');
            $('#password').trigger('blur');
            $('#repeatPassword').trigger('blur');

            if (
                $('#login').hasClass('error') ||
                $('#age').hasClass('error') ||
                $('#password').hasClass('error') ||
                $('#repeatPassword').hasClass('error')
            ) {
                return false;
            }

            if ($('#password').val().trim() != $('#repeatPassword').val().trim()) {
                error.innerText = "Пароли не совпадают!";
                $('#password').attr('class', 'error');
                $('#repeatPassword').attr('class', 'error');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
<div>
    <a href="..">Портфолио</a> &bull; <a href=".">MVC</a> &bull; <a href="#">Регистрация</a>
    <hr>
</div>
<p>Введите данные для регистрации: </p>
<form id="registrationForm">
    <span>Логин:</span>
    <br>
    <input id="login" type="text" name="login">
    <div id="loginError" class="errorText"></div>

    <span>Город:</span>
    <input type="text" name="city" placeholder="не указан">

    <span>Возраст:</span>
    <br>
    <input id="age" type="text" name="age" placeholder="не указан">
    <div id="ageError" class="errorText"></div>

    <span>Пароль:</span>
    <br>
    <input id="password" type="password" name="password">
    <div id="passwordError" class="errorText"></div>

    <span>Повторите пароль:</span>
    <br>
    <input id="repeatPassword" type="password" name="repeatPassword">
    <div id="repeatPasswordError" class="errorText"></div>

    <input type="submit" value="Зарегестрироваться">
    <span id="error"></span>
</form>
<script>
    login.onblur = function () {
        if (!checkEmpty(this, loginError)) {
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

    age.onblur = function () {
        var ageString = this.value.trim();
        if (ageString.length != 0) {
            var age = Number(ageString);
            if (isNaN(age)) {
                this.className = 'error';
                ageError.innerText = "Возраст должен быть числом";
            } else if (age < 0) {
                this.className = 'error';
                ageError.innerText = "Возраст не может быть отрицательным";
            }
        }
    };

    age.onfocus = function () {
        dropError(this, ageError);
    }

    password.onblur = function () {
        checkEmpty(this, passwordError);
    };

    password.onfocus = function () {
        dropError(this, passwordError);
    }

    repeatPassword.onblur = function () {
        checkEmpty(this, repeatPasswordError);
    };

    repeatPassword.onfocus = function () {
        dropError(this, repeatPasswordError);
    }

    function checkEmpty(input, error) {
        if (input.value.trim().length == 0) {
            input.className = "error";
            error.innerHTML = 'Это поле должно быть заполнено';
            return false;
        }
        return true;
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