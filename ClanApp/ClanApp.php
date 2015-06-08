<?php

namespace ClanApp;

use ClanApp\core\Router;

class ClanApp {

	public function __construct() {

		$router = Router::getInstance();

		$controller = $router->getControllerObject();
		$controller->preAction();
		$controller->{$router->getActionName()}();
		$controller->renderView();

	}

}
