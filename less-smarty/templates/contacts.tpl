{extends file='header-footer.tpl'}

{block name="css"}
    <link rel="stylesheet" type="text/css" href="less-to-css/contacts-content.css" />
{/block}

{block name="content"}
    <div class="contacts">
        <h1>Контакты</h1>
        <div class="address">
            <h3>Адрес</h3>
            <p>199155 Санкт-Петербург,<br>
                ул. Уральская, дом 1/2<br>
                (БЦ Академия) офисы 222, 268</p>
            <p>E-mail: <a href="mailto:support@openstart.ru">support@openstart.ru</a></p>
            <p>Skype: <a href="callto:openstart.ru">openstart.ru</a></p>
            <p>Мы работаем<br>
                По будням с 10:00 до 19:00.</p>
        </div>
        <div class="phones">
            <h3>+7 (812) 385-63-32</h3>
            <p>Номер телефона в Санкт-Петербурге</p>
            <h3>+7 (499) 272-48-15</h3>
            <p>Номер телефона в Москве</p>
        </div>
    </div>
{/block}