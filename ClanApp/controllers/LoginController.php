<?php

namespace ClanApp\controllers;

use ClanApp\core\Authenticator;
use ClanApp\core\Controller;
use ClanApp\core\Router;

class LoginController extends Controller {

	public function index() {

		if (Router::isPost()) {
			$email = $_POST['email'];
			$password = $_POST['password'];
			Authenticator::performLogin($email, $password);
		}

	}

}
