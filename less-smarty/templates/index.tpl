{extends file='header-footer.tpl'}

{block name="css"}
    <link rel="stylesheet" type="text/css" href="less-to-css/index-content.css" />
{/block}

{block name="content"}
    <div class="slider">
        <h2>Профессиональная поддержка сайтов</h2>
        <a href="site-support.php">
            <img src="img/slider-1.png">
        </a>
    </div><div class="info">
        <h1>Доработка и поддержка сайтов</h1>
        <p>Принимаем на техническую поддержку и доработку сайты, разработанные сторонними разработчиками. Все наши
            программисты имеют сертификаты 1С-Битрикс, но мы так же работаем с любыми другими CMS и Framework-ами на базе
            PHP.</p>
        <p>Наши компетенции в технической поддержке сайтов:</p>
        <ul class="description">
            {foreach from=$abilities item=ability}
                <li>{$ability}</li>
            {/foreach}
        </ul>
        <div class="summary">
            <h3><span><b>418</b> проектов</span></h3>
            <h3><span><b>17200</b> задач</span></h3>
            <h3><span><b>8</b> летний опыт</span></h3>
        </div>
        <div class="clearfix"></div>
    </div>
{/block}