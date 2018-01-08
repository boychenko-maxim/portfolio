<?php

class Controller_Login extends Controller
{
	function action_index()
	{
        session_start();

        if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
            redirect('user');
        }

		$this->view->generate('login_view.php');
	}

	function action_canLogin()
    {
        $user = $this->users->getUser($_POST['userLogin'], $_POST['userPassword']);
        $canLogin = $user !== false;

        if ($canLogin) {
            session_start();

            $_SESSION['userLoggedIn'] = true;
            $_SESSION['userLogin'] = $_POST['userLogin'];
            $_SESSION['userPassword'] = $_POST['userPassword'];
            $_SESSION['userCity'] = $user->city;
            $_SESSION['userAge'] = $user->age;
        }

        echo boolToString($canLogin);
    }
}