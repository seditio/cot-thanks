<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.posts.loop
Tags=forums.posts.tpl:{FORUMS_POSTS_ROW_THANKS_CAN}, {FORUMS_POSTS_ROW_THANKS_URL}, {FORUMS_POSTS_ROW_THANKS_LINK}, {FORUMS_POSTS_ROW_THANKS_COUNT}, {FORUMS_POSTS_ROW_THANKS_LIST_URL}, {FORUMS_POSTS_ROW_THANKS_USERS}
[END_COT_EXT]
==================== */

/**
 * Thanks forum posts tags
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (Cot::$cfg['plugin']['thanks']['forums_on']) {

	Cot::$db->registerTable('thanks');
	$db_thanks = Cot::$db->thanks;

	$prefix = 'FORUMS_POSTS_ROW_';

	if (!isset($thanks_auth_write)) {
		require_once cot_langfile('thanks', 'plug');
		require_once cot_incfile('thanks', 'plug');
		include_once cot_incfile('thanks', 'plug', 'api');
		require_once cot_incfile('thanks', 'plug','resources');
		$thanks_auth_write = cot_auth('plug', 'thanks', 'W');
	}

	$fp_id = $row['fp_id'];
	$sql_limit = (Cot::$cfg['plugin']['thanks']['maxthanked']) ? " LIMIT " . Cot::$cfg['plugin']['thanks']['maxthanked'] : "";

	$res = $db->query("SELECT t.*, ft.ft_title, p.fp_cat, u.user_name
		FROM $db_thanks AS t
		LEFT JOIN $db_users AS u ON t.th_fromuser = u.user_id
		LEFT JOIN $db_forum_posts AS p ON t.th_ext = 'forums' AND t.th_item = p.fp_id
		LEFT JOIN $db_forum_topics AS ft ON p.fp_id > 0 AND p.fp_topicid = ft.ft_id
		WHERE `th_ext` = 'forums' AND `th_item` = $fp_id
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
		$prefix . 'THANKS_COUNT'    => thanks_get_number('forums', $fp_id),
		$prefix . 'THANKS_LIST_URL' => cot_url('thanks', 'a=viewdetails&ext=forums&item=' . $fp_id),
		$prefix . 'THANKS_USERS'    => $th_users_list,
	));

	if ($thanks_auth_write && !thanks_check_item($usr['id'], 'forums', $fp_id) && $usr['id'] != $row['fp_posterid'] && !$th_thanked) {
		$thanks_url = cot_url('thanks', 'a=thank&ext=forums&item=' . $fp_id);
		$t->assign(array(
			$prefix . 'THANKS_CAN'  => true,
			$prefix . 'THANKS_URL'  => $thanks_url,
			$prefix . 'THANKS_LINK' => cot_rc_link($thanks_url, $L['thanks_thanks'], array('class' => Cot::$cfg['plugin']['thanks']['forums_class'])),
		));
	} else {
		$t->assign(array(
			$prefix . 'THANKS_CAN' => false,
		));
	}
}
