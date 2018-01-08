<?php

class Controller_Registration extends Controller
{
    function action_index()
    {
        session_start();

        if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
            redirect('user');
        }

        $this->view->generate('registration_view.php');
    }

    function action_canRegister()
    {
        $canRegister = !$this->users->hasUser($_POST['login']);

        if ($canRegister) {
            $city = Users::prepareValue($_POST['city']);
            $age = Users::prepareValue($_POST['age']);

            $this->users->insertUser($_POST['login'], $_POST['password'], $city, $age);

            session_start();

            $_SESSION['userLoggedIn'] = true;
            $_SESSION['userLogin'] = $_POST['login'];
            $_SESSION['userCity'] = $city;
            $_SESSION['userAge'] = $age;
        }

        echo boolToString($canRegister);
        exit;
    }
}