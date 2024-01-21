<?php
/**
 * Manage group notification subscriptions
 */

echo elgg_view_page(elgg_echo('groups:usersettings:notifications:title'), [
	'content' => elgg_view_form('settings/notifications/groups', [
		'action' => 'action/settings/notifications/subscriptions',
	], [
		'entity' => elgg_get_page_owner_entity(),
	]),
	'show_owner_block_menu' => false,
	'filter_id' => 'settings/notifications',
	'filter_value' => 'groups',
]);
