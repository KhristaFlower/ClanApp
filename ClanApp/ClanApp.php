<?php

namespace ClanApp;

use ClanApp\core\Router;

class ClanApp {

	public function __construct() {

		$router = Router::getInstance();

		$router->processRoute($_SERVER['REQUEST_URI']);

		/** @var \ClanApp\core\Controller $controller */
		$controller = new $router->controllerClass();
		$controller->setRouter($router);

		$controller->preAction();
		$controller->{$router->action}();
		$controller->renderView();

	}

}
