<?php

return [
	'plugin' => [
		'version' => '3.0',
	],
	'actions' => [
		'login_as/login' => [
			'access' => 'admin',
		],
		'login_as/logout' => [],
	],
	'hooks' => [
		'register' => [
			'menu:topbar' => [
				\Elgg\LoginAs\TopbarMenuHandler::class => [],
			],
			'menu:user_hover' => [
				\Elgg\LoginAs\UserHoverMenuHandler::class => [],
			],
		],
	],
];
