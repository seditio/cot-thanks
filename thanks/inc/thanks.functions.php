<?php
/**
 * Thanks main functions
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

// define globals
define('SEDBY_THANKS_REALM', '[SEDBY] Thanks');

require_once cot_incfile('cotlib', 'plug');

function thanks_render_list($tpl = 'thanks.list', $items = 0, $order = '', $extra = '', $user = '', $pagination = '', $ajax_block = '', $cache_name = '', $cache_ttl = 0) {

	global $L, $R, $is_backend;

	$enableAjax = $enableCache = $enablePagination = false;

	// Condition shortcut
	if (Cot::$cache && !empty($cache_name) && ((int)$cache_ttl > 0) && (Cot::$usr['id'] == 0)) {
		$enableCache = true;
		$cache_name = str_replace(' ', '_', $cache_name);
	}

	if ($enableCache && Cot::$cache->db->exists($cache_name, SEDBY_THANKS_REALM)) {
		$output = Cot::$cache->db->get($cache_name, SEDBY_THANKS_REALM);
	} else {

		/* === Hook === */
		foreach (cot_getextplugins('thanks.list.first') as $pl) {
			include $pl;
		}
		/* ===== */

		// Condition shortcuts
		if ((Cot::$cfg['turnajax']) && (Cot::$cfg['plugin']['thanks']['ajax']) && !empty($ajax_block)) {
			$enableAjax = true;
		}

		if (!empty($pagination) && ((int)$items > 0)) {
			$enablePagination = true;
		}

		// DB tables shortcuts
		Cot::$db->registerTable('thanks');
		$db_thanks = Cot::$db->thanks;
		$db_users = Cot::$db->users;

		// Display the items
    (!isset($tpl) || empty($tpl)) && $tpl = 'thanks.list';
		$t = new XTemplate(cot_tplfile($tpl, 'plug'));

		// Get pagination if necessary
		if ($enablePagination) {
      list($pg, $d, $durl) = cot_import_pagenav($pagination, $items);
    } else {
      $d = 0;
    }

		// Compile order
		$sql_order = empty($order) ? "ORDER BY th_count DESC" : " ORDER BY $order";

		// Compile user_id
		$sql_user = (empty($user)) ? "" : "user_id = " . $user;

		// Compile extra SQL condition
		$sql_extra = (empty($extra)) ? "" : $extra;

		// Compile items number
		$sql_limit = ($items > 0) ? "LIMIT $d, $items" : "";

		// Non-zero var
		if (Cot::$cfg['plugin']['thanks']['nozero']) {
		 	$sql_nozero = "u.user_thanks > 0";
		}

		$sql_cond = sedby_build_where(array($sql_user, $sql_extra, $sql_nozero));

		/* === Hook === */
		foreach (cot_getextplugins('thanks.list.query') as $pl) {
			include $pl;
		}
		/* ===== */

		// Use extrafield rather than count???
		$res = Cot::$db->query("SELECT u.*,
			(SELECT COUNT(*) FROM $db_thanks AS t WHERE t.th_touser = u.user_id) AS th_count
			FROM $db_users
			AS u
			$sql_cond $sql_order $sql_limit");
		$jj = 0;

		/* === Hook - Part 1 === */
		$extp = cot_getextplugins('thanks.list.loop');
		/* ===== */

		while ($row = $res->fetch()) {
			$jj++;
			// Optionize???
			$t->assign(cot_generate_usertags($row, 'PAGE_ROW_USER_'));
			// Same for the th_fromuser???
			$t->assign(array(
				'PAGE_ROW_NUM' => $jj + $d,
				'PAGE_ROW_ODDEVEN' => cot_build_oddeven($jj),

				'PAGE_ROW_THANKS_TOTALCOUNT' => $row['th_count'],
				'PAGE_ROW_THANKS_MORE' => ($is_backend) ? cot_rc('more_back', array('link' => cot_url('admin', 'm=other&p=thanks&a=viewdetails&user=' . $row['user_id'], '', true))) : cot_rc('more_front', array('link' => cot_url('thanks', 'a=viewdetails&user=' . $row['user_id']))),
				'PAGE_ROW_THANKS_DELETE_USER' => ($is_backend) ? cot_rc('delete_back', array('link' => cot_confirm_url(cot_url('admin', 'm=other&p=thanks&a=removeall&user=' . $row['user_id'], '', true), 'thanks', 'thanks_remove_all'))) : '',
			));

			/* === Hook - Part 2 === */
			foreach ($extp as $pl) {
				include $pl;
			}
			/* ===== */

			$t->parse("MAIN.PAGE_ROW");
		}

		$t->assign(array(
			'PAGE_TOP_SYNC_URL' => cot_url('admin', 'm=other&p=thanks&a=sync'),
			'PAGE_TOP_FULLSYNC_URL' => cot_url('admin', 'm=other&p=thanks&a=fullsync'),
		));

		// Render pagination if needed
		if ($enablePagination) {
			$totalitems = Cot::$db->query("SELECT COUNT(*) FROM $db_users AS u $sql_cond")->fetchColumn();

			$url_area = sedby_geturlarea();
			$url_params = sedby_geturlparams();
			$url_params[$pagination] = $durl;

			if ($enableAjax) {
				$ajax_mode = true;
				$ajax_plug = 'plug';
				if (Cot::$cfg['plugin']['thanks']['encrypt_ajax_urls']) {
					$h = $tpl . ',' . $items . ',' . $order . ',' . $extra . ',' . $user . ',' . $pagination . ',' . $ajax_block . ',' . $cache_name . ',' . $cache_ttl . ',list';
					$h = sedby_encrypt_decrypt('encrypt', $h, Cot::$cfg['plugin']['thanks']['encrypt_key'], Cot::$cfg['plugin']['thanks']['encrypt_iv']);
					$h = str_replace('=', '', $h);
					$ajax_plug_params = "r=thanks&h=$h";
				} else {
					$ajax_plug_params = "r=thanks&tpl=$tpl&items=$items&order=$order&extra=$extra&user=$user&pagination=$pagination&ajax_block=$ajax_block&cache_name=$cache_name&cache_ttl=$cache_ttl&area=list";
				}
			} else {
				$ajax_mode = false;
				$ajax_plug = $ajax_plug_params = '';
			}

			$pagenav = cot_pagenav($url_area, $url_params, $d, $totalitems, $items, $pagination, '', $ajax_mode, $ajax_block, $ajax_plug, $ajax_plug_params);

			// Assign pagination tags
			$t->assign(array(
				'PAGE_TOP_PAGINATION'  => $pagenav['main'],
				'PAGE_TOP_PAGEPREV'    => $pagenav['prev'],
				'PAGE_TOP_PAGENEXT'    => $pagenav['next'],
				'PAGE_TOP_FIRST'       => $pagenav['first'],
				'PAGE_TOP_LAST'        => $pagenav['last'],
				'PAGE_TOP_CURRENTPAGE' => $pagenav['current'],
				'PAGE_TOP_TOTALLINES'  => $totalitems,
				'PAGE_TOP_MAXPERPAGE'  => $items,
				'PAGE_TOP_TOTALPAGES'  => $pagenav['total']
			));
		}

		($jj == 0) && $t->parse("MAIN.NONE");

		/* === Hook === */
		foreach (cot_getextplugins('thanks.list.tags') as $pl) {
			include $pl;
		}
		/* ===== */

		$t->parse();
		$output = $t->text();

		if ($enableCache && !$enablePagination && ($jj > 1)) {
			Cot::$cache->db->store($cache_name, $output, SEDBY_THANKS_REALM, $cache_ttl);
		}
	}
	return $output;
}

function thanks_render_user($tpl = 'thanks.user', $items = 0, $order = '', $extra = '', $user = '', $pagination = '', $ajax_block = '', $cache_name = '', $cache_ttl = 0) {

	$enableAjax = $enableCache = $enablePagination = false;

	// Condition shortcut
	if (Cot::$cache && !empty($cache_name) && ((int)$cache_ttl > 0) && (Cot::$usr['id'] == 0)) {
		$enableCache = true;
		$cache_name = str_replace(' ', '_', $cache_name);
	}

	if ($enableCache && Cot::$cache->db->exists($cache_name, SEDBY_THANKS_REALM)) {
		$output = Cot::$cache->db->get($cache_name, SEDBY_THANKS_REALM);
	} else {

		/* === Hook === */
		foreach (cot_getextplugins('thanks.user.first') as $pl) {
			include $pl;
		}
		/* ===== */

		// Condition shortcuts
		if ((Cot::$cfg['turnajax']) && (Cot::$cfg['plugin']['thanks']['ajax']) && !empty($ajax_block)) {
			$enableAjax = true;
		}

		if (!empty($pagination) && ((int)$items > 0)) {
			$enablePagination = true;
		}

		// DB tables shortcuts
		Cot::$db->registerTable('thanks');
		$db_com = Cot::$db->com;
		$db_forum_topics = Cot::$db->forum_topics;
		$db_forum_posts = Cot::$db->forum_posts;
		$db_pages = Cot::$db->pages;
		$db_thanks = Cot::$db->thanks;
		$db_users = Cot::$db->users;

		// Display the items
    (!isset($tpl) || empty($tpl)) && $tpl = 'thanks.user';
		$t = new XTemplate(cot_tplfile($tpl, 'plug'));

		// Get pagination if necessary
		if ($enablePagination) {
      list($pg, $d, $durl) = cot_import_pagenav($pagination, $items);
    } else {
      $d = 0;
    }

		// Compile order
		$sql_order = empty($order) ? "ORDER BY th_date DESC" : " ORDER BY $order";

		// Compile user_id
		$sql_user = (empty($user)) ? "" : "th_touser = " . $user;

		// Compile extra SQL condition
		$sql_extra = (empty($extra)) ? "" : $extra;

		$sql_cond = sedby_build_where(array($sql_user, $sql_extra));

		// Compile items number
		$sql_limit = ($items > 0) ? "LIMIT $d, $items" : "";

		$thanks_join_columns = "";
		$thanks_join_tables = "";

		// Get to and from user names
		$thanks_join_columns .= ", (SELECT user_name FROM $db_users AS tu WHERE tu.user_id = t.th_touser) AS to_name ";
		$thanks_join_columns .= ", (SELECT user_name FROM $db_users AS fu WHERE fu.user_id = t.th_fromuser) AS from_name ";

		/* === Hook === */
		foreach (cot_getextplugins('thanks.user.query') as $pl) {
			include $pl;
		}
		/* ===== */

		$res = Cot::$db->query("SELECT t.* $thanks_join_columns
			FROM $db_thanks AS t
			$thanks_join_tables
			$sql_cond $sql_order $sql_limit");

		$jj = 0;

		/* === Hook - Part 1 === */
		$extp = cot_getextplugins('thanks.user.loop');
		/* ===== */

		while ($row = $res->fetch()) {
			$jj++;
			$t->assign(array(
				'PAGE_ROW_ID'					=> $row['th_id'],
				'PAGE_ROW_DATE'				=> cot_date('d-m-Y H:i:s', $row['th_date']),
				'PAGE_ROW_DATE_STAMP'	=> $row['th_date'],

				'PAGE_ROW_TO_NAME'		=> sedby_user_exists($row['th_touser']) ? htmlspecialchars($row['to_name']) : "",
				'PAGE_ROW_TO_URL'			=> sedby_user_exists($row['th_touser']) ? cot_url('users', 'm=details&id=' . $row['th_touser'] . '&u=' . urlencode($row['to_name'])) : "",

				'PAGE_ROW_FROM_NAME'	=> sedby_user_exists($row['th_fromuser']) ? htmlspecialchars($row['from_name']) : "",
				'PAGE_ROW_FROM_URL'		=> sedby_user_exists($row['th_fromuser']) ? cot_url('users', 'm=details&id=' . $row['th_fromuser'] . '&u=' . urlencode($row['from_name'])) : "",

				'PAGE_ROW_DELETE'			=> cot_rc('delete_back', array('link' => cot_confirm_url(cot_url('admin', 'm=other&p=thanks&a=remove&user=' . $user . '&item=' . $row['th_id'], '', true), 'thanks', 'thanks_remove_one'))),
			));

			/* === Hook - Part 2 === */
			foreach ($extp as $pl) {
				include $pl;
			}
			/* ===== */

			$t->parse("MAIN.PAGE_ROW");
		}

		// Render pagination if needed
		if ($enablePagination) {
			$totalitems = Cot::$db->query("SELECT COUNT(*) FROM $db_thanks $sql_cond")->fetchColumn();

			$url_area = sedby_geturlarea();
			// global $a;
			// $url_params = array('a' => $a, 'user' => $user);
			$url_params = sedby_geturlparams();
			$url_params[$pagination] = $durl;

			if ($enableAjax) {
				$ajax_mode = true;
				$ajax_plug = 'plug';
				if (Cot::$cfg['plugin']['thanks']['encrypt_ajax_urls']) {
					$h = $tpl . ',' . $items . ',' . $order . ',' . $extra . ',' . $user . ',' . $pagination . ',' . $ajax_block . ',' . $cache_name . ',' . $cache_ttl . ',user';
					$h = sedby_encrypt_decrypt('encrypt', $h, Cot::$cfg['plugin']['thanks']['encrypt_key'], Cot::$cfg['plugin']['thanks']['encrypt_iv']);
					$h = str_replace('=', '', $h);
					$ajax_plug_params = "r=thanks&h=$h";
				} else {
					$ajax_plug_params = "r=thanks&tpl=$tpl&items=$items&order=$order&extra=$extra&user=$user&pagination=$pagination&ajax_block=$ajax_block&cache_name=$cache_name&cache_ttl=$cache_ttl&area=user";
				}
			} else {
				$ajax_mode = false;
				$ajax_plug = $ajax_plug_params = '';
			}

			$pagenav = cot_pagenav($url_area, $url_params, $d, $totalitems, $items, $pagination, '', $ajax_mode, $ajax_block, $ajax_plug, $ajax_plug_params);

			// Assign pagination tags
			$t->assign(array(
				'PAGE_TOP_PAGINATION'  => $pagenav['main'],
				'PAGE_TOP_PAGEPREV'    => $pagenav['prev'],
				'PAGE_TOP_PAGENEXT'    => $pagenav['next'],
				'PAGE_TOP_FIRST'       => '',
				'PAGE_TOP_LAST'        => $pagenav['last'],
				'PAGE_TOP_CURRENTPAGE' => $pagenav['current'],
				'PAGE_TOP_TOTALLINES'  => $totalitems,
				'PAGE_TOP_MAXPERPAGE'  => $items,
				'PAGE_TOP_TOTALPAGES'  => $pagenav['total']
			));
		}

		($jj == 0) && $t->parse("MAIN.NONE");

		/* === Hook === */
		foreach (cot_getextplugins('thanks.user.tags') as $pl) {
			include $pl;
		}
		/* ===== */

		$t->parse();
		$output = $t->text();

		if ($enableCache && !$enablePagination && ($jj > 1)) {
			Cot::$cache->db->store($cache_name, $output, SEDBY_THANKS_REALM, $cache_ttl);
		}
	}
	return $output;
}
