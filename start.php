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
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'login_as_user_hover_menu');
	elgg_register_plugin_hook_handler('register', 'menu:topbar', \Elgg\LoginAs\TopbarMenuHandler::class);
	
	elgg_extend_view('css/elgg', 'login_as/css');

	$action_path = dirname(__FILE__) . '/actions/';
	elgg_register_action('login_as', $action_path . 'login_as.php', 'admin');
	elgg_register_action('logout_as', $action_path . 'logout_as.php');
}

/**
 * Add Login As to user hover menu for admins
 *
 * @param string         $hook   "register"
 * @param string         $type   "menu:user_hover"
 * @param ElggMenuItem[] $menu   Menu
 * @param array          $params Hook params
 * @return ElggMenuItem[]
 */
function login_as_user_hover_menu($hook, $type, $menu, $params) {

	$user = elgg_extract('entity', $params);
	$logged_in_user = elgg_get_logged_in_user_entity();

	if (!$user instanceof ElggUser) {
		return;
	}

	if (!$logged_in_user || !$logged_in_user->isAdmin()) {
		return;
	}

	// Don't show menu on self.
	if ($logged_in_user == $user) {
		return;
	}

	$url = "action/login_as?user_guid=$user->guid";
	$menu[] = ElggMenuItem::factory(array(
		'name' => 'login_as',
		'text' => elgg_echo('login_as:login_as'),
		'href' => $url,
		'is_action' => true,
		'section' => 'admin'
	));

	return $menu;
}
