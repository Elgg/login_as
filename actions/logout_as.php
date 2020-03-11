<?php
/**
 * Logout as the current user, back to the original user.
 */

$session = elgg_get_session();

$user_guid = $session->get('login_as_original_user_guid');
$persistent = (bool) $session->get('login_as_original_persistent');

$user = get_user($user_guid);
if (!$user instanceof ElggUser || !$user->isAdmin()) {
	return elgg_error_response(elgg_echo('login_as:unknown_user'));
}

if (!login($user, $persistent)) {
	return elgg_error_response(elgg_echo('login_as:could_not_login_as_user'), [$user->username]);
}

$session->remove('login_as_original_user_guid');
$session->remove('login_as_original_persistent');

return elgg_ok_response('', elgg_echo('login_as:logged_in_as_user', [$user->username]));
