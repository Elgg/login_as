<?php

namespace Elgg\LoginAs;

class TopbarMenuHandler {

	/**
	 * Add a menu item to the topbar menu for logging out of an account
	 *
	 * @param \Elgg\Hook Hook 'register', 'menu:topbar'
	 *
	 * @return \Elgg\Menu\MenuItems|void
	 */
	public function __invoke(\Elgg\Hook $hook) {

		$session = elgg_get_session();

		$original_user_guid = $session->get('login_as_original_user_guid');

		// short circuit view if not logged in as someone else.
		if (!$original_user_guid) {
			return;
		}
		
		$original_user = get_user($original_user_guid);
		if (!$original_user instanceof \ElggUser) {
			return;
		}

		$title = elgg_echo('login_as:return_to_user', [
			$original_user->getDisplayName(),
		]);
		
		$icon = elgg_view('output/img', [
			'src' => $original_user->getIconURL(['size' => 'tiny']),
			'alt' => 'original user photo',
		]);
		$icon = elgg_format_element('span' , ['class' => ['elgg-avatar', 'elgg-avatar-tiny', 'elgg-anchor-icon']], $icon);

		$menu = $hook->getValue();
		
		$menu[] = \ElggMenuItem::factory([
			'name' => 'login_as_return',
			'icon' => $icon,
			'text' => $title,
			'href' => elgg_generate_action_url('login_as/logout'),
			'link_class' => 'login-as-topbar',
			'priority' => -100,
			'section' => 'alt',
			'parent_name' => 'account',
		]);

		return $menu;
	}
}
