<?php

namespace ClanApp\core;

class Router {

	private static $instance;

    private $controller;
    private $action;

    private function __construct() {

        // Determine the controller to use based on the request.
//        $url = isset($_GET['url']) ? $_GET['url'] : 'home'; // Apache and .htaccess method.
        $url = trim($_SERVER['REQUEST_URI'], '/'); // nginx method.
		$url = $url ?: 'home'; // The default path to use should one not have been specified.

		// In the case of root '/' we would not be correctly setting the controller name below.
        $urlParts = explode('/', $url) ?: [];

        $this->controller = $urlParts[0];
        $this->action = isset($urlParts[1]) ? $urlParts[1] : 'index';

    }

	public static function getInstance() {

		if (!self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Used to determine if the request method is GET.
	 *
	 * @return bool True if request method is GET.
	 */
	public static function isGet() {
		return $_SERVER['REQUEST_METHOD'] === 'GET';
	}

	/**
	 * Used to determine if the request method is POST.
	 *
	 * @return bool True if request method is POST.
	 */
	public static function isPost() {
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}

	/**
     * @return Controller
     */
    public function getControllerObject() {
        $controllerName = sprintf('\\ClanApp\\controllers\\%sController', ucfirst($this->controller));

		/** @var Controller $controller Create the controller */
		$controller = new $controllerName();
		$controller->setRouter($this);
		return $controller;
    }

    public function getControllerName() {
        return $this->controller;
    }

    public function getActionName() {
        return $this->action;
    }

	public static function redirect($controller, $action = null) {

		if (headers_sent()) {
			throw new \Exception('Redirect failed; headers already sent!');
		}

		$location = "/" . implode('/', array_filter([$controller, $action]));

		header("Location: $location");
		exit;

	}

}
