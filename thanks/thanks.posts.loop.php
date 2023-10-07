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
	$ext = 'forums';
	$item = $row['fp_id'];
	$item_owner = $row['fp_posterid'];

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

	$res = $db->query("SELECT t.*, ft.ft_title, p.fp_cat, u.user_name
		FROM $db_thanks AS t
		LEFT JOIN $db_users AS u ON t.th_fromuser = u.user_id
		LEFT JOIN $db_forum_posts AS p ON t.th_ext = '$ext' AND t.th_item = p.fp_id
		LEFT JOIN $db_forum_topics AS ft ON p.fp_id > 0 AND p.fp_topicid = ft.ft_id
		WHERE `th_ext` = '$ext' AND `th_item` = $item
		ORDER BY th_date DESC
		$sql_limit");

	foreach ($res as $t_row) {
		(!empty($th_users_list)) && $th_users_list .= $R['thanks_divider'];
		$th_users_list .= cot_rc_link(cot_url('users', 'm=details&id=' . $t_row['th_fromuser'] . '&u=' . ($t_row['user_name'])), $t_row['user_name']);
		(!$cfg['plugin']['thanks']['short']) && $th_users_list .= $R['thanks_bracket_open'] . cot_date('date_full', $t_row['th_date']) . $R['thanks_bracket_close'];
		($th_thanked || $usr['id'] == $t_row['th_fromuser']) && $th_thanked = true;
	}

	$t->assign(array(
		$prefix . 'THANKS_COUNT'    => thanks_get_number($ext, $item),
		$prefix . 'THANKS_LIST_URL' => cot_url('thanks', 'a=viewdetails&ext=' . $ext . '&item=' . $item),
		$prefix . 'THANKS_USERS'    => $th_users_list,
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
