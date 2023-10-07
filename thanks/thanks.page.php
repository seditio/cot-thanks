<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.tags
Tags=page.tpl:{PAGE_THANKS_CAN}, {PAGE_THANKS_URL}, {PAGE_THANKS_LINK}, {PAGE_THANKS_COUNT}, {PAGE_THANKS_LIST_URL}, {PAGE_THANKS_USERS}
[END_COT_EXT]
==================== */

/**
 * Thanks page tags
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (Cot::$cfg['plugin']['thanks']['page_on']) {

	Cot::$db->registerTable('thanks');
	$db_thanks = Cot::$db->thanks;

	$prefix = 'PAGE_';
	$ext = 'page';
	$item = $pag['page_id'];
	$item_owner = $pag['page_ownerid'];

	$sql_limit = (Cot::$cfg['plugin']['thanks']['maxthanked']) ? " LIMIT " . Cot::$cfg['plugin']['thanks']['maxthanked'] : "";

	$th_users_list = '';
	$th_thanked = false;

	if (!isset($thanks_auth_write)) {
		require_once cot_langfile('thanks', 'plug');
		require_once cot_incfile('thanks', 'plug');
		include_once cot_incfile('thanks', 'plug', 'api');
		require_once cot_incfile('thanks', 'plug','resources');
		$thanks_auth_write = cot_auth('plug', 'thanks', 'W');
	}

	// $res = $db->query("SELECT t.*, u.user_name
	// 	FROM $db_thanks AS t
	// 	LEFT JOIN $db_users AS u ON t.th_fromuser = u.user_id
	// 	WHERE `th_ext` = 'page' AND `th_item` = $page_id
	// 	ORDER BY th_date DESC
	// 	$sql_limit");

	$res = $db->query("SELECT t.*, (SELECT user_name FROM $db_users AS u WHERE t.th_fromuser = u.user_id) AS user_name
		FROM $db_thanks AS t
		WHERE th_ext = '$ext' AND th_item = $item
		ORDER BY th_date DESC
		$sql_limit");

	$t->assign(array(
		$prefix . 'THANKS_COUNT'    => thanks_get_number($ext, $item),
		$prefix . 'THANKS_LIST_URL' => cot_url('thanks', 'a=viewdetails&ext=' . $ext . '&item=' . $item),
		$prefix . 'THANKS_USERS'    => thanks_gen_userlist($res),
	));

	if ($thanks_auth_write && !thanks_check_item($usr['id'], $ext, $item) && $usr['id'] != $item_owner && !$th_thanked) {
		$thanks_url = cot_url('thanks', 'a=thank&ext=' . $ext . '&item=' . $item);
		$t->assign(array(
			$prefix . 'THANKS_CAN'  => true,
			$prefix . 'THANKS_URL'  => $thanks_url,
			$prefix . 'THANKS_LINK' => cot_rc_link($thanks_url, $L['thanks_thanks'], array('class' => Cot::$cfg['plugin']['thanks'][$ext . '_class'])),
		));
	} else {
		$t->assign(array(
			$prefix . 'THANKS_CAN' => false,
		));
	}
}
