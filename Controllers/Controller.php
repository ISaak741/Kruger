<?php

namespace Controllers;

use Application\Views;

class Controller
{
	public function index()
	{
		echo Views::view('index');
	}

	public function render($name)
	{
		echo "<h1> hello $name </h1>";
	}

	public function _404()
	{
		echo Views::view('404');
	}
}
