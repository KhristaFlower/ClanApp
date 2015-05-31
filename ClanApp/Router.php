<?php

namespace ClanApp;

class Router {

    private $controller;
    private $action;

    public function __construct() {

        // Load the URL sent to us from the .htaccess
        $url = isset($_GET['url']) ? $_GET['url'] : 'home';

        $urlParts = explode('/', $url);

        $this->controller = $urlParts[0];
        $this->action = isset($urlParts[1]) ? $urlParts[1] : 'index';

    }

    /**
     * @return Controller
     */
    public function getControllerObject() {
        $controllerName = sprintf('\\ClanApp\\controllers\\%sController', ucfirst($this->controller));

        /** @var Controller $controller Create the controller */
        $controller = new $controllerName();
        $controller->setRouterObject($this);
        return $controller;
    }

    public function getControllerName() {
        return $this->controller;
    }

    public function getActionName() {
        return $this->action;
    }

}
