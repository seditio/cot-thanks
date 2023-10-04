<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.loop
Tags=comments.tpl:{COMMENTS_ROW_THANK_CAN},{COMMENTS_ROW_THANK_URL},{COMMENTS_ROW_THANK_LINK},{COMMENTS_ROW_THANK_COUNT},{COMMENTS_ROW_THANK_USERS},{COMMENTS_ROW_USERS_DATES},{FORUMS_POSTS_ROW_THANKFUL}
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

	require_once cot_incfile('thanks', 'plug');
	require_once cot_incfile('thanks', 'plug', 'resources');

	global $db_thanks, $db_users, $db_com, $cfg, $db;

	$item = $row['com_id'];
	$res = $db->query("SELECT t.*, c.com_id, u.user_name
		FROM $db_thanks AS t
		LEFT JOIN $db_users AS u ON t.th_fromuser = u.user_id
		LEFT JOIN $db_com AS c ON t.th_ext = 'comments' AND t.th_item = c.com_id
		WHERE `th_ext` = 'comments' AND `th_item` = $item
		ORDER BY th_date DESC
		LIMIT $d, " . $cfg['plugin']['thanks']['usersperpage']);

	$th_users_list = '';
	$th_users_list_dates = '';

	$th_thanked = false;

	foreach ($res as $rows) {
		if ($cfg['plugin']['thanks']['short']) {
		if (!empty($th_users_list)) {
			$th_users_list .= ', ';
		}
		$th_users_list .= cot_rc_link(cot_url('users', 'm=details&id=' . $rows['th_fromuser'] . '&u=' . ($rows['user_name'])), $rows['user_name']);
			if ( $th_thanked || $usr['id'] == $rows['th_fromuser'] )
			 $th_thanked = true;

		} else {
			if (!empty($th_users_list_dates)) {
				$th_users_list_dates .= ', ';
			}
			$th_users_list_dates .=	cot_rc_link(cot_url('users', 'm=details&id=' . $rows['th_fromuser'] . '&u='.($rows['user_name'])), $rows['user_name']);
			$th_users_list_dates .= $R['open'] . cot_date('d-m-Y', cot_date2stamp($rows['th_date'])) . $R['close'];
			if ($th_thanked || $usr['id'] == $rows['th_fromuser']) {
				$th_thanked = true;
			}
		}
	}

	$total = $db->query("SELECT COUNT(*) FROM $db_thanks WHERE th_ext = 'comments' AND th_item = $item")->fetchColumn();

	$t->assign(array(
		'COMMENTS_ROW_THANKFUL' => $L['thanks_tag'],
		'COMMENTS_ROW_THANKS_COUNT' => $total,
	));

	if ($cfg['plugin']['thanks']['short']) {
		$t->assign(array('COMMENTS_ROW_THANK_USERS' => $th_users_list));
	} else {
		$t->assign(array('COMMENTS_ROW_USERS_DATES' => $th_users_list_dates));
	}

	// Fallback
	$t->assign(array(
		'COMMENTS_ROW_THANK_CAN' => false,
		'COMMENTS_ROW_THANK_URL' => cot_url('thanks', 'ext=comments&item=' . $row['com_id']),
		'COMMENTS_ROW_THANK_LINK' => '',
		'COMMENTS_ROW_THANK_COUNT' => (int) $row['thanks_count']
	));

	if (cot_auth('plug', 'thanks', 'W') && $usr['id'] != $row['com_authorid'] && (int)$row['com_authorid'] > 0) {
		$thanks_today = $db->query("SELECT COUNT(*) FROM `$db_thanks` WHERE `th_fromuser` = {$usr['id']} AND DATE(`th_date`) = DATE(NOW())")->fetchColumn();
		$thanks_touser_today = $row['thanks_touser_today'];
		$thanks_toitem = $row['thanks_toitem'];

		if ($thanks_today < $cfg['plugin']['thanks']['maxday'] && $thanks_touser_today < $cfg['plugin']['thanks']['maxuser'] && $thanks_toitem < 1)	{
			$t->assign(array(
				'COMMENTS_ROW_THANK_CAN' => true,
				'COMMENTS_ROW_THANK_URL' => cot_url('thanks', 'a=thank&ext=comments&item='.$row['com_id']),
				'COMMENTS_ROW_THANK_LINK' => cot_rc_link(cot_url('thanks', 'a=thank&ext=comments&item=' . $row['com_id']), $L['thanks_thanks'])
			));
		}
	}

}
