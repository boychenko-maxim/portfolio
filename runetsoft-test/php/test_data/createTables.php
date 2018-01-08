<?php
include('../pdoHelper.php');

$pdo = getMysqlPDO('../../../databaseSettings.php');

createEducationTable($pdo);
createUsersTable($pdo);
createCitiesTable($pdo);
createUsersCitiesTable($pdo);

function createEducationTable($pdo): void
{
    prepareAndExecuteSql($pdo,
        "CREATE TABLE Education(
            qualification_id int AUTO_INCREMENT,
            name varchar(30) NOT NULL,
            PRIMARY KEY (qualification_id)
        )"
    );
    echoTableIsCreated('Education');
}

function createUsersTable($pdo): void
{
    prepareAndExecuteSql($pdo,
        "CREATE TABLE Users(
            user_id int AUTO_INCREMENT,
            name varchar(60) NOT NULL,
            qualification_id int,
            PRIMARY KEY (user_id),
            FOREIGN KEY (qualification_id) REFERENCES Education(qualification_id)
        )"
    );
    echoTableIsCreated('Users');
}

function createCitiesTable($pdo): void
{
    prepareAndExecuteSql($pdo,
        "CREATE TABLE Cities(
            city_id int AUTO_INCREMENT,
            name varchar(50) NOT NULL,
            PRIMARY KEY (city_id)
        )"
    );
    echoTableIsCreated('Cities');
}

function createUsersCitiesTable($pdo) : void
{
    prepareAndExecuteSql($pdo,
        "CREATE TABLE UsersCities(
            user_id int,
            city_id int,
            PRIMARY KEY (user_id, city_id),
            FOREIGN KEY (user_id) REFERENCES Users(user_id),
            FOREIGN KEY (city_id) REFERENCES Cities(city_id)
        )"
    );
    echoTableIsCreated('UsersCities');
}

function echoTableIsCreated($name)
{
    echo "Table '{$name}' is created";
    echo "<br>";
}

