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

	list($pg_pages_thanks, $d_pages_thanks, $durl_pages_thanks) = cot_import_pagenav('d', $cfg['plugin']['thanks']['usersperpage']);

	$page_id = $pag['page_id'];

	$res = $db->query("SELECT t.*, pag.page_alias, pag.page_title, pag.page_cat, u.user_name
		FROM $db_thanks AS t
		LEFT JOIN $db_users AS u ON t.th_fromuser = u.user_id
		LEFT JOIN $db_pages AS pag ON t.th_ext = 'page' AND t.th_item = pag.page_id
		WHERE `th_ext` = 'page' AND `th_item` = $page_id
		ORDER BY th_date DESC
		LIMIT $d_pages_thanks, " . Cot::$cfg['plugin']['thanks']['usersperpage']);

	$th_users_list = '';
	$th_users_list_dates = '';

	// Already thanked
	$th_thanked = false;

	// Checking if user is in thanked people list
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
		$th_users_list_dates .= $R['open'] . cot_date('d-m-Y', cot_date2stamp($rows['th_date'])) . $R['close'];
			if ($th_thanked || $usr['id'] == $rows['th_fromuser']) {
				$th_thanked = true;
			}
		}
	}

	if ($cfg['plugin']['thanks']['short']) {
		$t->assign('PAGE_THANK_USERS', $th_users_list);
	} else {
		$t->assign('PAGE_THANK_USERS_DATES', $th_users_list_dates);
	}
	$t->assign('FORUMS_POSTS_ROW_THANKFUL', $L['thanks_tag']);

	if ($thanks_auth_write && !thanks_check_item($usr['id'], 'page', $id) && $usr['id'] != $pag['page_ownerid'] && !$th_thanked) {
		$t->assign(array(
			'PAGE_THANK_CAN' => true,
			'PAGE_THANK_URL' => cot_url('plug', 'e=thanks&a=thank&ext=page&item='.$id),
			'PAGE_THANK_LINK' => cot_rc_link(cot_url('plug', 'e=thanks&a=thank&ext=page&item='.$id), $L['thanks_thanks'], array('class' => Cot::$cfg['plugin']['thanks']['page_class'])),
		));
	} else {
		$t->assign(array(
			'PAGE_THANK_CAN' => false,
			'PAGE_THANK_URL' => cot_url('plug', 'e=thanks&ext=page&item='.$id),
			'PAGE_THANK_LINK' => '',
		));
	}

}
