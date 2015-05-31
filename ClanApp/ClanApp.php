<?php

namespace ClanApp;

class ClanApp {

    public function __construct() {

        $router = new Router();

        $controller = $router->getControllerObject();
        $controller->{$router->getActionName()}();
        $controller->renderView();

    }

}
