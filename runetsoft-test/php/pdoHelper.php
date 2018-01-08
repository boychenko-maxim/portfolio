<?php

function getMysqlPDO() {
    $databaseSettings = getDatabaseSettings();

    $pdo = new PDO(
        sprintf(
            'mysql:host=%s;dbname=%s;port=%s;charset=%s',
            $databaseSettings['host'],
            $databaseSettings['name'],
            $databaseSettings['port'],
            $databaseSettings['charset']
        ),
        $databaseSettings['username'],
        $databaseSettings['password']
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

function prepareAndExecuteSql($pdo, $sql)
{
    $statement = $pdo->prepare($sql);
    $statement->execute();
    return $statement;
}

function getDatabaseSettings() {
    return array(
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'maximb7i_test',
        'username' => 'maximb7i_test',
        'password' => '123456',
        'charset' => 'utf8'
    );
}