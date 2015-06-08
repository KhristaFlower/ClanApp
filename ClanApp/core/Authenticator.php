<?php

namespace ClanApp\core;

class Authenticator {

	public function __construct() {

		$sessionData = isset($_SESSION) ? $_SESSION : [];

		// Check for a logged in user.
		if (!isset($sessionData['key'])) {

			// Redirect to login if we aren't there already.
			if (Router::getInstance()->getControllerName() != 'login') {
//				Router::redirect('login');
			}

			return;
		}

		$sessionKey = $sessionData['key'];

	}

	public static function performLogin() {

	}

	/**
	 * @return bool
	 */
	public static function loggedIn() {

		// Temp solution while I get the other systems in place.
		return isset($_SESSION['key']);

	}

}
