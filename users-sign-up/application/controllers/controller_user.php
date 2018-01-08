<?php

class Controller_User extends Controller
{
    function action_index()
    {
        session_start();

        if (!isset($_SESSION['userLoggedIn']) || !$_SESSION['userLoggedIn']) {
            redirect('');
        }

        $this->view->generate('user_view.php',
            array(
                'userLogin' => $_SESSION['userLogin'],
                'userCity' => $_SESSION['userCity'],
                'userAge' => $_SESSION['userAge']
            )
        );
    }

    function action_edit()
    {
        session_start();

        if (!isset($_SESSION['userLoggedIn']) || !$_SESSION['userLoggedIn']) {
            redirect('');
        }

        $this->view->generate('user_edit.php',
            array(
                'userLogin' => $_SESSION['userLogin'],
                'userCity' => $_SESSION['userCity'],
                'userAge' => $_SESSION['userAge']
            )
        );
    }

    function action_update()
    {
        $city = Users::prepareValue($_POST['city']);
        $age = Users::prepareValue($_POST['age']);

        session_start();

        $this->users->updateUser($_SESSION['userLogin'], $city, $age);

        $_SESSION['userCity'] = $city;
        $_SESSION['userAge'] = $age;

        exit;
    }

    function action_logout()
    {
        session_start();

        $_SESSION['userLoggedIn'] = false;

        redirect('');
    }
}