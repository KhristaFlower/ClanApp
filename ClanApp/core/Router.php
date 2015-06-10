<?php

namespace ClanApp\core;

class Router {

	/**
	 * @var self A single router instance.
	 */
	private static $instance;

	/** @var string The part of the URL which comes before the controller. */
	public $path;

	/** @var string The name of the controller extracted from the URL. */
    public $controller;

	/** @var string The method to call on the controller based on the URL. */
	public $action;

	/**
	 * @var string The fully qualified class name for the controller.
	 * new $this->controllerClass(); will create the required controller.
	 */
	public $controllerClass;

	/**
	 * @var string This is the same as the $controllerClass however it has an added ::view component.
	 * This is used in unit testing to ensure the validity of the parsed route.
	 * // TODO: Replace this with a function to calculate the final result, we don't need this unless testing.
	 */
	public $controllerClassAction; // Used for Unit tests.

    private function __construct() {

    }

	/**
	 * This function takes a URL route and uses it to determine the controller (and its location)
	 * as well as the view.
	 *
	 * @param $route
	 * @return $this
	 * @throws \Exception
	 */
	public function processRoute($route) {

		// Separate the query string (if one) from the input.
		$url = explode('?', $route)[0];

		/*
		 * The controller and action we need to call can be found in the URL, unfortunately due
		 * to readability, we aren't using a static format. I wanted to be able to place controllers
		 * at any location inside the controllers folder and have the router take that into
		 * consideration. Because of this we need to try a bunch of different known possibilities
		 * to calculate what we need.
		 *
		 * Take the following example: /manage/members/view
		 * The controller in the example would be the MembersController found at /controllers/manage/
		 * and view would be the method. However, this could just as easily be the ViewController
		 * found at /controllers/manage/members/ using the default (index) method. The last part of
		 * the URL is either going to be an action or a controller (using the default index action).
		 */

		if ($url == '/') {
			$url = '/home';
		}

		$routeParts = explode('/', trim($url, '/'));

		$path = null;
		$controller = null;
		$action = null;

		/*
		 * TODO: The below.
		 * Refine the part checking for 1 $routePart, we should be able to incorporate this into the general
		 * solution below. Failing that we could just add an index item to the $routeParts if it only has 1 item.
		 * It shouldn't break anything.
		 */
		if (count($routeParts) == 1) { // TODO: Refine.
			// The specified URL component will be a controller.
			$controller = $routeParts[0];
			$action = 'index';
			if (!self::validRoute(null, $controller, $action)) {
				throw new \Exception('404');
			}
		} else {
			// A destructible copy of the URL components array.
			$components = $routeParts;
			$lastComponent = array_pop($components); // Either controller or view.
			$secLastComponent = array_pop($components); // Either path or controller.
			// Anything left over at this point will form part of the path.
			$controllerPath = implode('/', $components);

			// The two end URL components will either be folder/controller or controller/action.
			$validControllerView = self::validRoute($controllerPath, $secLastComponent, $lastComponent);
			$validFolderController = self::validRoute(implode('/', [$controllerPath, $secLastComponent]), $lastComponent);

			if ($validControllerView) {
				$path = $controllerPath;
				$controller = $secLastComponent;
				$action = $lastComponent;
			} else if ($validFolderController) {
				$path = implode('/', array_filter([$controllerPath, $secLastComponent]));
				$controller = $lastComponent;
				$action = "index";
			} else {
				// TODO: An actual solution...
				throw new \Exception('404');
			}
		}

		$this->path = $path;
		$this->controller = $controller;
		$this->action = $action;

		$this->controllerClass = sprintf("\\ClanApp\\controllers\\%s%sController", strlen($path) > 0 ? "$path\\" : "", ucfirst($controller));
		$this->controllerClassAction = "{$this->controllerClass}::{$this->action}";

		return $this;
	}

	/**
	 * Tests whether the specified controller can be found if an $action is not provided,
	 * otherwise we will check to see if a function exists on the specified controller.
	 *
	 * @param string $path
	 * @param null $name
	 * @param null $action
	 * @return bool True if the folder/controller/action is found; false otherwise.
	 */
	private static function validRoute($path = "", $name = null, $action = null) {

		if (!$name) {
			throw new \InvalidArgumentException('Controller name required');
		}

		$name = ucfirst($name);
		if (strlen($path) > 0) {
			$path = trim($path, '/') . '/';
		}

		$controllerClass = str_replace('/', '\\', "/ClanApp/controllers/{$path}{$name}Controller");

		if (!$action) {
			// Check for a controller.
			return class_exists($controllerClass);
		} else {
			// Check for a function on the controller.
			return method_exists($controllerClass, $action);
		}

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
	 * Redirect the browser to another page.
	 *
	 * @param $location string The new path.
	 * @throws \Exception
	 */
	public static function redirect($location) {

		if (headers_sent()) {
			throw new \Exception('Redirect failed; headers already sent!');
		}

		header("Location: $location");
		exit;

	}

}
