<?php

return [
	'propel' => [
		'database' => [
			'connections' => [
				'FusionCore' => [
					'adapter' => 'mysql',
					'classname' => 'Propel\Runtime\Connection\DebugPDO',
					'dsn' => 'mysql:host=localhost;dbname=fusioncore',
					'user' => 'homestead',
					'password' => 'secret',
					'attributes' => []
				]
			]
		],
		'runtime' => [
			'defaultConnection' => 'FusionCore',
			'connections' => ['FusionCore']
		],
		'generator' => [
			'defaultConnection' => 'FusionCore',
			'connections' => ['FusionCore']
		]
	]
];
