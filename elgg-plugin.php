<?php

return [
	'actions' => [
		'login_as' => [
			'access' => 'admin',
		],
		'logout_as' => [],
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
