<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.posts.loop
Tags=forums.posts.tpl:{FORUMS_POSTS_ROW_THANK_CAN},{FORUMS_POSTS_ROW_THANK_URL},{FORUMS_POSTS_ROW_THANK_LINK},{FORUMS_POSTS_ROW_THANKS_USERS},{FORUMS_POSTS_ROW_THANKS_USERS_DATES},{FORUMS_POSTS_ROW_THANKFUL}
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

	if (!isset($thanks_auth_write)) {
		require_once cot_langfile('thanks', 'plug');
		require_once cot_incfile('thanks', 'plug');
		include_once cot_incfile('thanks', 'plug', 'api');
		require_once cot_incfile('thanks', 'plug','resources');
		$thanks_auth_write = cot_auth('plug', 'thanks', 'W');
	}

	list($pg_posts_thanks, $d_posts_thanks, $durl_posts_thanks) = cot_import_pagenav('d', Cot::$cfg['plugin']['thanks']['usersperpage']);

	$fp_id = $row['fp_id'];

	$res = $db->query("SELECT t.*, ft.ft_title, p.fp_cat, u.user_name
		FROM $db_thanks AS t
		LEFT JOIN $db_users AS u ON t.th_fromuser = u.user_id
		LEFT JOIN $db_forum_posts AS p ON t.th_ext = 'forums' AND t.th_item = p.fp_id
		LEFT JOIN $db_forum_topics AS ft ON p.fp_id > 0 AND p.fp_topicid = ft.ft_id
		WHERE `th_ext` = 'forums' AND `th_item` = $fp_id
		ORDER BY th_date DESC
		LIMIT $d_posts_thanks, " . Cot::$cfg['plugin']['thanks']['usersperpage']);

	$th_users_list = '';
	$th_users_list_dates = '';

	// Already thanked
	$th_thanked = false;

	// Checking if user is in the thanked list
	foreach ($res as $rows) {
		if ($cfg['plugin']['thanks']['short']) {
		if (!empty($th_users_list)) {
			$th_users_list .= ', ';
		}
		$th_users_list .= cot_rc_link(cot_url('users', 'm=details&id='.$rows['th_fromuser'].'&u='.($rows['user_name'])),$rows['user_name']);
			if ($th_thanked || $usr['id'] == $rows['th_fromuser']) {
				$th_thanked = true;
			}
		} else {
		if (!empty($th_users_list_dates)) {
			$th_users_list_dates .= ', ';
		}
		$th_users_list_dates .=	cot_rc_link(cot_url('users', 'm=details&id=' . $rows['th_fromuser'] . '&u=' . ($rows['user_name'])), $rows['user_name']);
		$th_users_list_dates .= " " . $R['open'] . cot_date('d-m-Y', cot_date2stamp($rows['th_date'])) . $R['close'];
			if ($th_thanked || $usr['id'] == $rows['th_fromuser']) {
				$th_thanked = true;
			}
		}
	}

	$t->assign(array(
		'FORUMS_POSTS_ROW_THANKFUL' => $L['thanks_tag'],
		'FORUMS_POSTS_ROW_THANKS' => $res->rowCount(),
	));

	if ($cfg['plugin']['thanks']['short']) {
		$t->assign('FORUMS_POSTS_ROW_THANKS_USERS', $th_users_list);
	} else {
		$t->assign('FORUMS_POSTS_ROW_THANKS_USERS_DATES', $th_users_list_dates);
	}

	if ($thanks_auth_write && !thanks_check_item($usr['id'], 'forums', $row['fp_id']) && $usr['id'] != $row['fp_posterid'] && !$th_thanked) {
		$t->assign(array(
			'FORUMS_POSTS_ROW_THANK_CAN' => true,
			'FORUMS_POSTS_ROW_THANK_URL' => cot_url('plug', 'e=thanks&a=thank&ext=forums&item='.$row['fp_id']),
			'FORUMS_POSTS_ROW_THANK_LINK' => cot_rc_link(cot_url('plug', 'e=thanks&a=thank&ext=forums&item='.$row['fp_id']), $L['thanks_thanks']),
		));
	} else {
		$t->assign(array(
			'FORUMS_POSTS_ROW_THANK_CAN' => false,
			'FORUMS_POSTS_ROW_THANK_URL' => '',
			'FORUMS_POSTS_ROW_THANK_LINK' => '',
		));
	}

}
