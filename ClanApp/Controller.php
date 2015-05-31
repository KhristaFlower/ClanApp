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

    public function __construct() {

        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/templates/");
        $this->smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/data/templates_c/");
        $this->smarty->setConfigDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/configs/");
        $this->smarty->setCacheDir($_SERVER['DOCUMENT_ROOT'] . "/../ClanApp/cache/");

        $this->smarty->debugging = false;

    }

    public function setRouterObject(Router $router) {
        $this->routerObject = $router;
    }

    public function renderView() {
        $controllerName = $this->routerObject->getControllerName();
        $actionName = $this->routerObject->getActionName();
        $displayFile = "pages/$controllerName/$actionName.tpl";
        $this->smarty->display($displayFile);
    }

}
