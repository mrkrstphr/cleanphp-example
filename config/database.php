<?php

return [
	'default' => 'sqlite',
	'connections' => [
		'sqlite' => [
			'driver' => 'sqlite',
			'database' => storage_path() . '/database.db',
		]
	]
];
