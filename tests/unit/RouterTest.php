<?php


class RouterTest extends \Codeception\TestCase\Test
{
	use \Codeception\Specify;

    // tests
    public function testRouteParsing()
    {

		$tests = [
			// URL => Controller::view
			'/' => '\\ClanApp\\controllers\\HomeController::index',
			'/manage' => '\\ClanApp\\controllers\\ManageController::index',
			'/manage/members' => '\\ClanApp\\controllers\\manage\\MembersController::index',
			'/manage/members/view' => '\\ClanApp\\controllers\\manage\\MembersController::view',
			'/manage/members/view?id=1' => '\\ClanApp\\controllers\\manage\\MembersController::view'
		];

		$router = \ClanApp\core\Router::getInstance();

		foreach ($tests as $route => $controller) {
			$this->assertSame($controller, $router->processRoute($route)->controllerClassAction);
		}

    }

}
