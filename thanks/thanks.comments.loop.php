<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.loop
Tags=comments.tpl:{COMMENTS_ROW_THANKS_CAN}, {COMMENTS_ROW_THANKS_URL}, {COMMENTS_ROW_THANKS_LINK}, {COMMENTS_ROW_THANKS_COUNT}, {COMMENTS_ROW_THANKS_LIST_URL}, {COMMENTS_ROW_THANKS_USERS}
[END_COT_EXT]
==================== */

/**
 * Thanks comments loop
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (Cot::$cfg['plugin']['thanks']['comments_on']) {

	Cot::$db->registerTable('thanks');
	$db_thanks = Cot::$db->thanks;
	$db_com = Cot::$db->com;
	$db_users = Cot::$db->users;

	$prefix = 'COMMENTS_ROW_';

	if (!isset($thanks_auth_write)) {
		require_once cot_langfile('thanks', 'plug');
		require_once cot_incfile('thanks', 'plug');
		include_once cot_incfile('thanks', 'plug', 'api');
		require_once cot_incfile('thanks', 'plug','resources');
		$thanks_auth_write = cot_auth('plug', 'thanks', 'W');
	}

	$item = $row['com_id'];
	$sql_limit = (Cot::$cfg['plugin']['thanks']['maxthanked']) ? " LIMIT " . Cot::$cfg['plugin']['thanks']['maxthanked'] : "";

	$res = Cot::$db->query("SELECT t.*, c.com_id, u.user_name
		FROM $db_thanks AS t
		LEFT JOIN $db_users AS u ON t.th_fromuser = u.user_id
		LEFT JOIN $db_com AS c ON t.th_ext = 'comments' AND t.th_item = c.com_id
		WHERE `th_ext` = 'comments' AND `th_item` = $item
		ORDER BY th_date DESC
		$sql_limit");

	$th_users_list = '';
	$th_thanked = false;

	foreach ($res as $t_row) {
		(!empty($th_users_list)) && $th_users_list .= $R['thanks_divider'];
		$th_users_list .= cot_rc_link(cot_url('users', 'm=details&id=' . $t_row['th_fromuser'] . '&u=' . ($t_row['user_name'])), $t_row['user_name']);
		(!$cfg['plugin']['thanks']['short']) && $th_users_list .= $R['thanks_bracket_open'] . cot_date('date_full', $t_row['th_date']) . $R['thanks_bracket_close'];
		($th_thanked || $usr['id'] == $t_row['th_fromuser']) && $th_thanked = true;
	}

	$t->assign(array(
		$prefix . 'THANKS_COUNT'    => thanks_get_number('comments', $item),
		$prefix . 'THANKS_LIST_URL' => cot_url('thanks', 'a=viewdetails&ext=comments&item=' . $item),
		$prefix . 'THANKS_USERS'    => $th_users_list,
	));

	if ($thanks_auth_write && !thanks_check_item($usr['id'], 'comments', $item) && $usr['id'] != $row['com_authorid'] && !$th_thanked) {
		$thanks_url = cot_url('thanks', 'a=thank&ext=comments&item=' . $item);
		$t->assign(array(
			$prefix . 'THANKS_CAN'  => true,
			$prefix . 'THANKS_URL'  => $thanks_url,
			$prefix . 'THANKS_LINK' => cot_rc_link($thanks_url, $L['thanks_thanks'], array('class' => Cot::$cfg['plugin']['thanks']['comments_class'])),
		));
	} else {
		$t->assign(array(
			$prefix . 'THANKS_CAN' => false,
		));
	}
}
