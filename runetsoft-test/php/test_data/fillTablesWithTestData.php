<?php
include('../pdoHelper.php');

$pdo = getMysqlPDO('../../../databaseSettings.php');

fillEducationTableWithTestData($pdo);
fillUsersTableWithTestData($pdo);
fillCitiesTableWithTestData($pdo);
fillUsersCitiesTableWithTestData($pdo);

function fillEducationTableWithTestData($pdo): void
{
    prepareAndExecuteSql($pdo,
        "INSERT INTO Education(name)
        VALUES 
            ('студент'),
            ('бакалавр'),
            ('магистр')"
    );

    echoTableIsFilledWithTestData('Education');
}

function fillUsersTableWithTestData($pdo): void
{
    prepareAndExecuteSql($pdo,
        "INSERT INTO Users(name, qualification_id)
        VALUES
          ('Карпова Наталья Олеговна', 1),
          ('Богданов Аристарх Геннадьевич', 1),
          ('Орлов Авксентий Романович', 1),
          ('Матвеева Регина Брониславовна', 2),
          ('Фадеева Анастасия Максимовна', 2),
          ('Шашков Иван Аристархович', 2),
          ('Селезнёва Нинель Артёмовна', 2),
          ('Тихонова Екатерина Мэлоровна', 3),
          ('Романов Фёдор Григорьевич', 3),
          ('Дьячкова Александра Антоновна', 3),
          ('Дьячкова Александра Антоновна', 1)"
    );

    echoTableIsFilledWithTestData('Users');
}

function fillCitiesTableWithTestData($pdo): void
{
    prepareAndExecuteSql($pdo,
        "INSERT INTO Cities(name)
        VALUES
          ('Мурманск'),
          ('Норильск'),
          ('Красноярск'),
          ('Муром'),
          ('Санкт-Петербург'),
          ('Москва'),
          ('Владивосток')"
    );

    echoTableIsFilledWithTestData('Cities');
}

function fillUsersCitiesTableWithTestData($pdo): void
{
    prepareAndExecuteSql($pdo,
        "INSERT INTO UsersCities(user_id, city_id)
        VALUES 
            (1, 2),
            (1, 3),
            (1, 5),
            (2, 5),
            (3, 7),
            (3, 6),
            (4, 5),
            (4, 4),
            (5, 5),
            (5, 1),
            (6, 2),
            (7, 7),
            (8, 6),
            (9, 3),
            (10, 5),
            (11, 5)"
    );

    echoTableIsFilledWithTestData('UsersCities');
}

function echoTableIsFilledWithTestData($tableName) : void
{
    echo "Table '{$tableName}' is filled with test data";
    echo "<br>";
}