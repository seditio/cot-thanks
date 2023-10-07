<?php
/**
 * Thanks API
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('thanks', 'plug');

Cot::$db->registerTable('thanks');

define('THANKS_ERR_NONE', 0);
define('THANKS_ERR_MAXDAY', 1);
define('THANKS_ERR_MAXUSER', 2);
define('THANKS_ERR_ITEM', 3);
define('THANKS_ERR_SELF', 4);

/**
 * Adds a new thank. Don't forget to use thanks_check() before calling this function.
 *
 * @param int $touser Thank receiver ID
 * @param int $fromuser Thank sender ID
 * @param string $ext Extension code
 * @param int $item Item ID
 * @return bool
 */
function thanks_add($touser, $fromuser, $ext, $item) {
	Cot::$cache && Cot::$cache->clear_realm(SEDBY_THANKS_REALM, COT_CACHE_TYPE_ALL);
	$db_thanks = Cot::$db->thanks;
	$db_users = Cot::$db->users;

	$ins = Cot::$db->insert($db_thanks, array(
		'th_date' => Cot::$sys['now'],
		'th_touser' => $touser,
		'th_fromuser' => $fromuser,
		'th_ext' => $ext,
		'th_item' => $item
	));
	if ($ins) {

		/* === Hook === */
		foreach (cot_getextplugins('thanks.add.done') as $pl) {
			include $pl;
		}
		/* ===== */

		Cot::$db->query("UPDATE $db_users SET user_thanks = user_thanks + 1 WHERE user_id = ?", array($touser));
	}
	return (bool) $ins;
}

/**
 * Checks if it is correct to add a new thank
 *
 * @param int $touser Thank receiver ID
 * @param int $fromuser Thank sender ID
 * @param string $ext Extension code
 * @param int $item Item ID
 * @return int One of the THANKS_ERR_* constants, THANKS_ERR_NONE if it is OK to add this thank.
 */
function thanks_check($touser, $fromuser, $ext, $item) {
	$db_thanks = Cot::$db->thanks;

	if ($touser == $fromuser) {
		return THANKS_ERR_SELF;
	}

	if (Cot::$db->query("SELECT COUNT(*) FROM $db_thanks WHERE th_fromuser = ? AND DATE(th_date) = DATE(NOW())", array($fromuser))->fetchColumn() >= Cot::$cfg['plugin']['thanks']['maxday']) {
		return THANKS_ERR_MAXDAY;
	}

	if (Cot::$db->query("SELECT COUNT(*) FROM $db_thanks WHERE `th_fromuser` = ? AND `th_touser` = ? AND DATE(`th_date`) = DATE(NOW())", array($fromuser, $touser))->fetchColumn() >= Cot::$cfg['plugin']['thanks']['maxuser']) {
		return THANKS_ERR_MAXUSER;
	}

	if (Cot::$db->query("SELECT COUNT(*) FROM $db_thanks WHERE `th_fromuser` = ? AND `th_ext` = ? AND `th_item` = ?", array($fromuser, $ext, $item))->fetchColumn() >= 1) {
		return THANKS_ERR_ITEM;
	}

	return THANKS_ERR_NONE;
}

/**
 * Returns TRUE if the user has already thanked for given item or FALSE otherwise.
 *
 * @param int $fromuser Thank sender ID
 * @param string $ext Extension code
 * @param int $item Item ID
 * @return bool
 */
function thanks_check_item($fromuser, $ext, $item) {
	$db_thanks = Cot::$db->thanks;
	return Cot::$db->query("SELECT COUNT(*) FROM $db_thanks WHERE th_fromuser = ? AND th_ext = ? AND th_item = ?", array($fromuser, $ext, $item))->fetchColumn() >= 1;
}

/**
 * Removes a thank by ID
 *
 * @param int $id Thank ID
 * @return bool
 */
function thanks_remove($id) {
	Cot::$cache && Cot::$cache->clear_realm(SEDBY_THANKS_REALM, COT_CACHE_TYPE_ALL);
	$db_thanks = Cot::$db->thanks;
	// $db_users = Cot::$db->users;
	// $touser = Cot::$db->query("SELECT th_touser FROM $db_thanks WHERE th_id = ?", array($id))->fetchColumn();
	$rm = Cot::$db->delete($db_thanks, "`th_id` = ?", array($id));
	if ($rm) {
		// Cot::$db->query("UPDATE $db_users SET user_thanks = user_thanks - 1 WHERE user_id = ?", array($touser));
		// cot_message('thanks_removed', 'ok');
		thanks_sync();
	}
	return (bool) $rm;
}

/**
 * Removes all thanks received by a user
 *
 * @param int $user_id User ID
 * @return int Number of items removed
 */
function thanks_remove_user($user_id) {
	global $L, $Ls;
	include_once cot_langfile('thanks', 'plug');
	Cot::$cache && Cot::$cache->clear_realm(SEDBY_THANKS_REALM, COT_CACHE_TYPE_ALL);
	$db_thanks = Cot::$db->thanks;
	$rm = Cot::$db->delete($db_thanks, "`th_touser` = ?", array($user_id));
	if ($rm) {
		cot_message($L['thanks_user_removed'] . ": " . cot_declension($rm, 'Entries'), 'ok');
		thanks_sync();
	} else {
		cot_message($L['thanks_user_removed_zero'], 'warning');
		thanks_sync();
	}
	return (bool) $rm;
}

/**
 * Resyncs thanks
 */
function thanks_sync() {
	global $L, $Ls;
	include_once cot_langfile('thanks', 'plug');
	Cot::$cache && Cot::$cache->clear_realm(SEDBY_THANKS_REALM, COT_CACHE_TYPE_ALL);
	$db_thanks = Cot::$db->thanks;
	$db_users = Cot::$db->users;
	Cot::$db->query("UPDATE $db_users SET user_thanks = 0");
	$query = "SELECT DISTINCT th_touser FROM $db_thanks";
	$res = Cot::$db->query($query);
	if ($res) {
		$jj = 0;
		while ($row = $res->fetch()) {
			$count = Cot::$db->query("SELECT COUNT(*) FROM $db_thanks WHERE th_touser = ?", array($row['th_touser']))->fetchColumn();
			Cot::$db->query("UPDATE $db_users SET user_thanks = $count WHERE user_id = ?", array($row['th_touser']));
			$jj++;
		}
	}
	$result = $L['thanks_sync_complete'];
	if ($jj) {
		$result .=  ": " . cot_declension($jj, 'Accounts');
	} else {
		$result .=  ": " . mb_strtolower($L['thanks_none']);
	}
	cot_message($result, 'ok');
}

/**
 * Returns number of thanks received by a user
 *
 * @param int $user_id User ID
 * @return int Number of thanks received by user
 */
function thanks_user_thanks_count($user_id) {
	$db_thanks = Cot::$db->thanks;
	return Cot::$db->query("SELECT COUNT(*) FROM $db_thanks WHERE th_touser = ?", array($user_id))->fetchColumn();
}

/**
 * Returns number of thanks for an element (page, post or comment)
 *
 * @param string $area Area (extension)
 * @param int    $element_id Element ID
 * @return int   Number of thanks
 */
function thanks_count($ext, $item) {
	$db_thanks = Cot::$db->thanks;
	switch ($ext) {
		case 'page':
			return Cot::$db->query("SELECT COUNT(*) FROM $db_thanks WHERE th_ext = 'page' and th_item = ?", array($item))->fetchColumn();
			break;
		case 'forums':
			return Cot::$db->query("SELECT COUNT(*) FROM $db_thanks WHERE th_ext = 'forums' and th_item = ?", array($item))->fetchColumn();
			break;
		case 'comments':
			return Cot::$db->query("SELECT COUNT(*) FROM $db_thanks WHERE th_ext = 'comments' and th_item = ?", array($item))->fetchColumn();
			break;
	}
}

/**
 * Gets number of likes for the element
 *
 * @param string $area Area (extension)
 * @param int    $element_id Element ID
 * @return int   Number of likes
 */
function thanks_get_number($ext, $item) {
	return Cot::$db->query("SELECT COUNT(*) FROM " . Cot::$db->thanks . " WHERE th_ext = ? AND th_item = ?", array($ext, $item))->fetchColumn();
}

function thanks_wrong_parameter() {
	cot_message('thanks_err_wrong_parameter', 'error');
	cot_redirect(cot_url('thanks'));
}

function thanks_fullsync() {
	$deleted_thanks = 0;
	$query = "SELECT * FROM " . Cot::$db->thanks;
	$res = Cot::$db->query($query);
	while ($row = $res->fetch()) {
		if (!sedby_user_exists($row['th_touser']) || !sedby_user_exists($row['th_fromuser']) || !thanks_item_exists($row['th_ext'], $row['th_item'])) {
			thanks_remove($row['th_id']);
			$deleted_thanks++;
		}
	}
	if ($deleted_thanks > 0) {
		cot_message('thanks_fullsync_complete_1', 'warning');
	} else {
		cot_message('thanks_fullsync_complete_0', 'ok');
	}
}

function thanks_item_exists($ext, $item) {
	switch ($ext) {
		case 'page':
			$db_pages = Cot::$db->pages;
			return Cot::$db->query("SELECT COUNT(*) FROM $db_pages WHERE page_id = ?", array($item))->fetchColumn();
			break;
		case 'forums':
			$db_forum_posts = Cot::$db->forum_posts;
			return Cot::$db->query("SELECT COUNT(*) FROM $db_forum_posts WHERE fp_id = ?", array($item))->fetchColumn();
			break;
		case 'comments':
			$db_com = Cot::$db->com;
			return Cot::$db->query("SELECT COUNT(*) FROM $db_com WHERE com_id = ?", array($item))->fetchColumn();
			break;
	}
}

function thanks_gen_userlist($res) {
	foreach ($res as $t_row) {
		(!empty($th_users_list)) && $th_users_list .= Cot::$R['thanks_divider'];
		$th_users_list .= cot_rc_link(cot_url('users', 'm=details&id=' . $t_row['th_fromuser'] . '&u=' . ($t_row['user_name'])), $t_row['user_name']);
		(!$cfg['plugin']['thanks']['short']) && $th_users_list .= Cot::$R['thanks_bracket_open'] . cot_date('date_full', $t_row['th_date']) . Cot::$R['thanks_bracket_close'];
		($th_thanked || $usr['id'] == $t_row['th_fromuser']) && $th_thanked = true;
	}
	return $th_users_list;
}
