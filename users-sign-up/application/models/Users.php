<?php

class Users
{
    private $pdo;

    function __construct()
    {
        $this->pdo = getMysqlPDO();
    }

    function getUser(string $userLogin, string $userPassword)
    {
        $user = $this->pdo->prepare("SELECT * FROM Users WHERE login=:userLogin AND passwordHash=:userPasswordHash");
        $user->execute(
            array(
                ':userLogin' => $userLogin,
                ':userPasswordHash' => md5($userPassword)
            )
        );
        return $user->fetchObject();
    }

    function hasUser(string $name)
    {
        $statement = $this->pdo->prepare("SELECT * FROM Users WHERE login=:userLogin");
        $statement->execute(array(':userLogin' => $name));
        return $statement->fetchObject() !== false;
    }

    function insertUser($login, $password, $city, $age)
    {
        $statement = $this->pdo->prepare("INSERT INTO Users(login, passwordHash, city, age)
                                       VALUES (
                                            :userLogin, 
                                            :userPasswordHash,
                                            Coalesce(:userCity, Default(city)),
                                            Coalesce(:userAge, Default(age))
                                       )"
        );

        $statement->execute(array(
                ':userLogin' => $login,
                ':userPasswordHash' => md5($password),
                ':userCity' => $city,
                ':userAge' => $age
            )
        );
    }

    function updateUser($login, $city, $age)
    {
        $statement = $this->pdo->prepare(
            "UPDATE Users
                SET city = Coalesce(:city, Default(city)),
                    age = Coalesce(:age, Default(age))
                WHERE login = :login"
        );

        $statement->execute(array(
                ':city' => $city,
                ':age' => $age,
                ':login' => $login
            )
        );
    }

    static function prepareValue($value)
    {
        $trimValue = trim($value);
        $valueIsSet = strlen($trimValue) != 0;
        return $valueIsSet ? $trimValue : NULL;
    }
}