<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>Редактирование</title>
    <style>
        p {
            margin: 0;
        }
        form {
            width: 215px;
        }
        #result {
            height: 20px;
        }
        input {
            margin-bottom: 5px;
        }
        form span {
            display: inline-block;
            margin-bottom: 5px;
        }
        .errorText {
            font-size: small;
            color: red;
            margin-bottom: 5px;
        }
        input[type=text] {
            border: 1px solid black;
        }

        input[type=text]:focus{
            border: 1px solid blue;
        }

        input[type=text].error{
            border-color: red;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(function () {
            $('#editForm').submit(function (event) {
                event.preventDefault();

                $('#age').trigger('blur');

                if ($('#age').hasClass('error')) {
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '/users-sign-up/user/update',
                    data: $(this).serialize()
                }).done(function() {
                    $('#result').text('Данные успешно обновлены!');
                });
            })
        });
    </script>
</head>
<body>
<div>
    <a href="../..">Портфолио</a> &bull;
    <a href="#">MVC</a> &bull;
    <a href="..">Страница пользователя</a> &bull;
    <a href="#">Редактирование данных пользователя</a>
    <hr>
</div>

<p>Пользователь: <?=htmlspecialchars($data['userLogin'])?></p>

<form id="editForm">
    <span>Город:</span>
    <br>
    <input type="text" name="city"
        <?php if (isset($data['userCity'])): ?>
            value="<?=htmlspecialchars($data['userCity'])?>"
        <?php else: ?>
            placeholder="не указан"
        <?php endif; ?>
    >

    <span>Возраст:</span>
    <br>
    <input id="age" type="text" name="age"
        <?php if (isset($data['userAge'])): ?>
            value="<?=htmlspecialchars($data['userAge'])?>"
        <?php else: ?>
            placeholder="не указан"
        <?php endif; ?>
    >
    <div id="ageError" class="errorText"></div>

    <input type="submit" value="Редактировать">
</form>

<div id="result"></div>

<br>

<form action="/users-sign-up/user">
    <input type="submit" value="Вернуться на домашнюю страницу">
</form>

<script>
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

    function dropError(input, error) {
        if (input.className == 'error') { // сбросить состояние "ошибка", если оно есть
            input.className = "";
            error.innerHTML = "";
        }
    }
</script>
</body>
</html>