<?php

define('PROJECT_ROOT', __DIR__ . '/../');

function dieDumpJSON(...$arguments) {

	$output = [];

	$argNo = 0;

	foreach ($arguments as $arg) {
		$output["Arg$argNo"] = $arg;
		$argNo++;
	}

	header('content-type:text/json');
	exit(json_encode($output));

}

require_once '../vendor/autoload.php';

$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

$clanApp = new \ClanApp\ClanApp();
