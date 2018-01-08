## Структура проекта
  - css
    - **index-template.css** - оформление приложения, подключается в **index-template.html**
  - js
    - **filterByEducationAndCities.js** - фильтрация по образованию и городам,
    подключается в **index-template.html**
  - php
    - test
      - **createTables.php** - создает пустые таблицы, согласно тестовому заданию
      - **dropTables.php** - удаляет все таблицы, был нужен при разработке, для того, чтобы снова выполнить **createTables.php** и затем  **fillTablesWithTestData.php**
      - **fillTablesWithTestData.php** - заполнение таблиц тестовыми данными
    - **pdoHelper.php** - содержит функцию для получения обьекта PDO и данные для доступа к БД
  - **index.php** - запуск приложения
  - **index-template.html** - pure-шаблонизация, подключается в **index.php**
