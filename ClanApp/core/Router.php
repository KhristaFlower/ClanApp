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

		// Used to remove the query string as we don't need it to calculate the controller.
		$route = explode('?', $route)[0];

		if ($route == '/') {
			$route = '/home';
		}

		$routeParts = explode('/', trim($route, '/'));

		if (count($routeParts) == 1) {
			$routeParts[] = 'index';
		}

		$lastComponent = array_pop($routeParts); // Either controller or view.
		$secondLastComponent = array_pop($routeParts); // Either path or controller.
		// Anything left over at this point will form part of the path.
		$controllerPath = implode('/', $routeParts);

		// The two end URL components will either be folder/controller or controller/action.
		$validControllerView = self::isValidRoute($controllerPath, $secondLastComponent, $lastComponent);
		$validFolderController = self::isValidRoute(implode('/', [$controllerPath, $secondLastComponent]), $lastComponent);

		if ($validControllerView) {
			$this->path = $controllerPath;
			$this->controller = $secondLastComponent;
			$this->action = $lastComponent;
		} else if ($validFolderController) {
			$this->path = implode('/', array_filter([$controllerPath, $secondLastComponent]));
			$this->controller = $lastComponent;
			$this->action = "index";
		} else {
			// TODO: An actual solution... (current stuff is for tests)
			$this->controllerClassAction = '404';
			return $this;
			//throw new \Exception('404');
		}

		$this->controllerClass = sprintf("\\ClanApp\\controllers\\%s%sController", strlen($this->path) > 0 ? "{$this->path}\\" : "", ucfirst($this->controller));
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
	private static function isValidRoute($path = "", $name = null, $action = null) {

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
