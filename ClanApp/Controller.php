<?php

namespace ClanApp;

class Controller {

    /**
     * @var Router
     */
    private $routerObject;

    /**
     * @var \Smarty
     */
    private $smarty;

	/**
	 * @var Sidebar
	 */
	private $sidebar;

    public function __construct() {

        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/templates/");
        $this->smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/data/templates_c/");
        $this->smarty->setConfigDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/configs/");
        $this->smarty->setCacheDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/cache/");

		$this->smarty->cache_lifetime = 100;

        $this->smarty->debugging = false;

		$this->generateSidebar();

    }

    public function setRouterObject(Router $router) {
        $this->routerObject = $router;
    }

    public function renderView() {

		if ($this->sidebar) {
			$this->smarty->assign('sidebar', $this->sidebar->getStructure());
		}

        $controllerName = $this->routerObject->getControllerName();
        $actionName = $this->routerObject->getActionName();
        $displayFile = "pages/$controllerName/$actionName.tpl";
        $this->smarty->display($displayFile);
    }

	public function generateSidebar() {

		$this->sidebar = new Sidebar();

		$this->sidebar->addItem('/', 'Home');
		$this->sidebar->addItem('/login', 'Log in', 'Accounts');
		$this->sidebar->addItem('/admin', 'Enter', 'Administration');

	}

}
