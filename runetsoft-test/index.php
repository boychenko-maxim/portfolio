<?php

include('php/pdoHelper.php');

$pdo = getMysqlPDO();

$education = [];
getEducationFromDatabase($pdo, $education);

$cities = [];
getCitiesFromDatabase($pdo, $cities);

$usersFullInfo = [];
getUsersFullInfoFromDatabase($pdo, $usersFullInfo);

function getEducationFromDatabase($pdo, & $education)
{
    $statement = prepareAndExecuteSql($pdo, "SELECT * FROM Education");
    while (($result = $statement->fetchObject()) !== false) {
        $education["{$result->qualification_id}"] = $result->name;
    }
}

function getCitiesFromDatabase($pdo, & $cities)
{
    $statement = prepareAndExecuteSql($pdo, "SELECT * FROM Cities");
    while (($result = $statement->fetchObject()) !== false) {
        $cities["{$result->city_id}"] = $result->name;
    }
}

function getUsersFullInfoFromDatabase($pdo, & $usersFullInfo)
{
    $statement = prepareAndExecuteSql($pdo,
        "SELECT 
            Users.user_id,
            Education.qualification_id,
            GROUP_CONCAT(Cities.city_id ORDER BY Cities.city_id ASC SEPARATOR ', ') AS 'cities_ids',
            Users.name AS 'user_name',
            Education.name AS 'education_name',
            GROUP_CONCAT(Cities.name ORDER BY Cities.name ASC SEPARATOR ', ') AS 'cities_names'
        FROM UsersCities LEFT JOIN (Users, Cities, Education) ON (
            Users.user_id = UsersCities.user_id AND
            Cities.city_id = UsersCities.city_id AND
            Users.qualification_id = Education.qualification_id
        )
        GROUP BY Users.user_id
        ORDER BY Users.name"
    );
    while (($result = $statement->fetchObject()) !== false) {
        $usersFullInfo["{$result->user_id}"] = ['qualification_id' => $result->qualification_id,
            'cities_ids' => $result->cities_ids,
            'user_name' => $result->user_name,
            'education_name' => $result->education_name,
            'cities_names' => $result->cities_names
        ];
    }
}

include('index-template.html');


