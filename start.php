<?php
/**
 * Provides an entry in the user hover menu for admins to login as the user.
 */

elgg_register_event_handler('init', 'system', 'login_as_init');

/**
 * Init
 * @return void
 */
function login_as_init() {

	// user hover menu and topbar links
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', \Elgg\LoginAs\UserHoverMenuHandler::class);
	elgg_register_plugin_hook_handler('register', 'menu:topbar', \Elgg\LoginAs\TopbarMenuHandler::class);
	
	elgg_extend_view('css/elgg', 'login_as/css');

	$action_path = dirname(__FILE__) . '/actions/';
	elgg_register_action('login_as', $action_path . 'login_as.php', 'admin');
	elgg_register_action('logout_as', $action_path . 'logout_as.php');
}

