<?php

namespace Elgg\LoginAs;

use Elgg\Hook;
use ElggMenuItem;
use ElggUser;
use Elgg\Menu\MenuItems;

class UserHoverMenuHandler {

	/**
	 * Add Login As to user hover menu for admins
	 *
	 * @param $hook \Elgg\Hook $hook 'register', 'menu:topbar'
	 *
	 * @return MenuItems
	 */
	public function __invoke(Hook $hook) {

		$user = $hook->getEntityParam();
		if (!$user instanceof ElggUser || $user->isBanned()) {
			// banned users are unable to login
			return;
		}

		$logged_in_user = elgg_get_logged_in_user_entity();
		if (!$logged_in_user instanceof \ElggUser || !$logged_in_user->isAdmin()) {
			return;
		}

		// Don't show menu on self.
		if ($logged_in_user->guid === $user->guid) {
			return;
		}

		/* @var $menu MenuItems */
		$menu = $hook->getValue();
		
		$menu[] = ElggMenuItem::factory([
			'name' => 'login_as',
			'icon' => 'sign-in',
			'text' => elgg_echo('login_as:login_as'),
			'href' => elgg_generate_action_url('login_as', [
				'user_guid' => $user->guid,
			]),
			'section' => 'admin',
		]);

		return $menu;
	}

}
