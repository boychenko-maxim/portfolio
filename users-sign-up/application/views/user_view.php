<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>Страница пользователя</title>
    <style>
        p {
            width: 200px;
            margin: 0;
        }
        form {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<div>
    <a href="..">Портфолио</a> &bull; <a href="#">MVC</a> &bull; <a href="#">Страница пользователя</a>
    <hr>
</div>
<p>
    Пользователь: <?=htmlspecialchars($data['userLogin'])?><br>
    Город: <?=htmlspecialchars($data['userCity'] ?? 'не указан')?><br>
    Возраст: <?=htmlspecialchars($data['userAge'] ?? 'не указан')?>
</p>
<form action="/users-sign-up/user/edit">
    <input type="submit" value="Редактировать данные">
</form>
<form action="/users-sign-up/user/logout">
    <input type="submit" value="Выход">
</form>
</body>
</html>