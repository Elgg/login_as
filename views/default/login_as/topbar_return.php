<?php
/**
 * A topbar link to return to original user.
 *
 * @uses $vars['user_guid'] The GUID of the original user
 */

$original_user_guid = elgg_extract('user_guid', $vars);
$original_user = get_user($original_user_guid);
if (!$original_user instanceof ElggUser) {
	return;
}

$logged_in_user = elgg_get_logged_in_user_entity();
if (!$logged_in_user instanceof ElggUser) {
	// how did we get here
	return;
}

$content = elgg_view('output/img', [
	'src' => $logged_in_user->getIconURL('tiny'),
	'alt' => $logged_in_user->getDisplayName(),
]);

$content .= elgg_view_icon('long-arrow-right');

$content .= elgg_view('output/img', [
	'src' => $original_user->getIconURL('tiny'),
	'alt' => $original_user->getDisplayName(),
]);

echo elgg_format_element('span', ['class' => ['elgg-avatar', 'elgg-avatar-tiny']], $content);
