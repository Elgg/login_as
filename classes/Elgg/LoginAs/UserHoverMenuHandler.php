<?php

namespace Elgg\LoginAs;

class UserHoverMenuHandler {

	/**
	 * Add Login As to user hover menu for admins
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:[user_hover|entity]'
	 *
	 * @return \Elgg\Menu\MenuItems|void
	 */
	public function __invoke(\Elgg\Hook $hook) {

		$user = $hook->getEntityParam();
		$logged_in_user = elgg_get_logged_in_user_entity();

		if (!$user instanceof \ElggUser || $user->isBanned()) {
			// no user or banned user is unable to login
			return;
		}

		if (!$logged_in_user || !$logged_in_user->isAdmin()) {
			// no admin user logged in
			return;
		}

		// Don't show menu on self.
		if ($logged_in_user->guid === $user->guid) {
			return;
		}

		$menu = $hook->getValue();
		
		$menu[] = \ElggMenuItem::factory([
			'name' => 'login_as',
			'icon' => 'sign-in-alt',
			'text' => elgg_echo('login_as:login_as'),
			'href' => elgg_generate_action_url('login_as/login', [
				'user_guid' => $user->guid,
			]),
			'section' => $hook->getType() === 'menu:user_hover' ? 'admin' : 'default',
		]);

		return $menu;
	}
}
