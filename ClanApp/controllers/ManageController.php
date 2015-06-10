<?php

namespace ClanApp\controllers;

use ClanApp\core\Controller;

class ManageController extends Controller {

	public function __construct() {

		parent::__construct();

	}

	public function generateSidebar() {

		parent::generateSidebar();

		$this->sidebar->addList('', [
			'/manage/members' => ''
		]);

	}

	public function index() {

	}

}
