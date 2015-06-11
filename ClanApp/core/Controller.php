<?php

namespace ClanApp\core;

class Controller {

	/**
	 * @var Router
	 */
	private $router;

	/**
	 * @var \Smarty
	 */
	private $smarty;

	/**
	 * @var Sidebar
	 */
	protected $sidebar;

	/**
	 * @var Authenticator
	 */
	private $authenticator;

	public function __construct() {

		$this->smarty = new \Smarty();
		$this->smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/templates/");
		$this->smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/data/templates_c/");
		$this->smarty->setConfigDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/configs/");
		$this->smarty->setCacheDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/cache/");
		$this->smarty->force_compile = true;
		$this->smarty->debugging = false;

		$this->authenticator = new Authenticator();

		$this->generateSidebar();

	}

	/*
	 * Fired after construct and before the requested action.
	 */
	public function preAction() {

	}

	public function setRouter(Router $router) {
		$this->router = $router;
	}

	public function renderView() {

		if ($this->sidebar) {
			$this->smarty->assign('sidebar', $this->sidebar->getStructure());
		}

		$controllerName = $this->router->controller;
		$actionName = $this->router->action;
		$path = $this->router->path . '/';
		$displayFile = "pages/{$path}{$controllerName}/{$actionName}.tpl";
		$this->smarty->display($displayFile);
	}

	public function generateSidebar() {

		$this->sidebar = new Sidebar();

		$this->sidebar->addItem('/', 'Home');
		$this->sidebar->addItem('/login', 'Log in', 'Accounts');
		$this->sidebar->addItem('/admin', 'Enter', 'Administration');

	}

}
