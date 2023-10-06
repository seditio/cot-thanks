<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.tags
Tags=page.tpl:{PAGE_THANK_CAN},{PAGE_THANK_URL},{PAGE_THANK_LINK},{PAGE_THANK_USERS_DATES},{PAGE_THANK_USERS},{FORUMS_POSTS_ROW_THANKFUL}
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

	if (!isset($thanks_auth_write)) {
		require_once cot_langfile('thanks', 'plug');
		require_once cot_incfile('thanks', 'plug');
		include_once cot_incfile('thanks', 'plug', 'api');
		require_once cot_incfile('thanks', 'plug','resources');
		$thanks_auth_write = cot_auth('plug', 'thanks', 'W');
	}

	$page_id = $pag['page_id'];
	$sql_limit = (Cot::$cfg['plugin']['thanks']['maxthanked']) ? " LIMIT " . Cot::$cfg['plugin']['thanks']['maxthanked'] : "";

	// $res = $db->query("SELECT t.*, u.user_name
	// 	FROM $db_thanks AS t
	// 	LEFT JOIN $db_users AS u ON t.th_fromuser = u.user_id
	// 	WHERE `th_ext` = 'page' AND `th_item` = $page_id
	// 	ORDER BY th_date DESC
	// 	$sql_limit");

	$res = $db->query("SELECT t.*, (SELECT user_name FROM $db_users AS u WHERE t.th_fromuser = u.user_id) AS user_name
		FROM $db_thanks AS t
		WHERE th_ext = 'page' AND th_item = $page_id
		ORDER BY th_date DESC
		$sql_limit");

	$th_users_list = '';
	$th_thanked = false;

	foreach ($res as $row) {
		(!empty($th_users_list)) && $th_users_list .= $R['thanks_divider'];
		$th_users_list .= cot_rc_link(cot_url('users', 'm=details&id=' . $row['th_fromuser'] . '&u=' . ($row['user_name'])), $row['user_name']);
		(!$cfg['plugin']['thanks']['short']) && $th_users_list .= $R['thanks_bracket_open'] . cot_date('date_full', $row['th_date']) . $R['thanks_bracket_close'];
		($th_thanked || $usr['id'] == $row['th_fromuser']) && $th_thanked = true;
	}

	$t->assign(array(
		'PAGE_THANKS_COUNT'    => thanks_get_number('page', $page_id),
		'PAGE_THANKS_LIST_URL' => cot_url('thanks', 'a=viewdetails&ext=page&item=' . $page_id),
		'PAGE_THANKS_USERS'    => $th_users_list,
	));

	if ($thanks_auth_write && !thanks_check_item($usr['id'], 'page', $id) && $usr['id'] != $pag['page_ownerid'] && !$th_thanked) {
		$thanks_url = cot_url('thanks', 'a=thank&ext=page&item=' . $id);
		$t->assign(array(
			'PAGE_THANKS_CAN'  => true,
			'PAGE_THANKS_URL'  => $thanks_url,
			'PAGE_THANKS_LINK' => cot_rc_link($thanks_url, $L['thanks_thanks'], array('class' => Cot::$cfg['plugin']['thanks']['page_class'])),
		));
	} else {
		$t->assign(array(
			'PAGE_THANKS_CAN' => false,
		));
	}
}
