<?php

class Controller {
    public $users;
	public $view;
	
	function __construct()
	{
	    $this->users = new Users();
		$this->view = new View();
	}
	
	// действие (action), вызываемое по умолчанию
	function action_index()
	{
		// todo	
	}
}
