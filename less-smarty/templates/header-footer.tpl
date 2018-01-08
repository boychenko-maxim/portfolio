<!doctype html>
<html lang="en">
<head>
    <title>day 9</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="less-to-css/header-footer.css" />
    {block name="css"}{/block}
</head>
<body>
    <div class="header">
        <div class="header-left">
            <a href="index.php">
                <img class="logo" src="img/logo.png">
            </a>
        </div>
        <div class="header-right">
            <div class="phone-menu">
                <div class="phones">
                    <div class="phone">+7 (812) <span class="bold">385-63-32</span></div>
                    <div class="phone">+7 (499) <span class="bold">272-48-15</span></div>
                    <img src="img/phone.png">
                </div>
                <div class="clearfix"></div>
                <ul class="menu">
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="contacts.php">Контакты</a></li>
                </ul>
            </div>
            <div class="mail-feedback">
                <div>
                    <a class="mail" href="mailto:support@openstart.ru">support@openstart.ru</a>
                </div>
                <div>
                    <a class="feedback-call" href="#">Обратный звонок</a>
                </div>
                <a class="feedback-order" href="#">Оставьте заявку</a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    {block name="content"}{/block}

    <div class="footer">
        <div class="footer-container">
            <div class="footer-left">
                <p>© 2009 — 2017 «OpenStart»</p>
                <p>Мы являемся официальным партнёром:</p>
                <ul>
                    <li><img src="img/partner-5.png"></li>
                    <li><img src="img/partner-1.jpg"></li>
                    <li><img src="img/partner-2.jpg"></li>
                    <li><img src="img/partner-3.jpg"></li>
                </ul>
            </div>
            <div class="footer-right">
                <p>199155, Санкт-Петербург, ул. Уральская, дом 1/2, офис 222</p>
                <div class="to-right">
                    <a class="mail" href="mailto:support@openstart.ru">support@openstart.ru</a>
                </div>
                <div class="clearfix"></div>
                <ul>
                    <li><img src="img/fb.png"></li>
                    <li><img src="img/vk.png"></li>
                    <li><img src="img/tw.png"></li>
                    <li><img src="img/insta.png"></li>
                </ul>
                <div class="clearfix"></div>
                <div class="privacy">
                    <a href="https://openstart.ru/privacy_policy.pdf">Политика конфиденциальности</a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</body>
</html>