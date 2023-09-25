<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Thanks main script
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

include_once cot_incfile('thanks', 'plug', 'api');

$out['subtitle'] = $L['thanks_meta_title'];
$out['desc'] = $L['thanks_meta_desc'];

$ext = cot_import('ext', 'G', 'ALP');
$item = cot_import('item', 'G', 'INT');
$user = cot_import('user', 'G', 'INT');

$is_backend = false;

// Условие для благодарности выполнено
if ($a == 'thank' && !empty($ext) && (int)$item > 0) {
	// Получаем ID владельца страницы, постера или комментатора
	if ($ext == 'page') {
		require_once cot_incfile('page', 'module');
		$res = $db->query("SELECT page_ownerid FROM $db_pages WHERE page_id = $item");
	} elseif ($ext == 'forums') {
		require_once cot_incfile('forums', 'module');
		$res = $db->query("SELECT fp_posterid FROM $db_forum_posts WHERE fp_id = $item");
	} elseif ($ext == 'comments') {
		require_once cot_incfile('comments', 'plug');
		$res = $db->query("SELECT com_authorid FROM $db_com WHERE com_id = $item");
	} else {
		$res = false;
	}
	// Присваиваем переменной $user значение ID
	if ($res && $res->rowCount() == 1 && $usr['auth_write']) {
		$user = $res->fetchColumn();
	} else {
		// $ext['status'] = '400 Bad Request';
		cot_die();
	}
	// Проверяем, разрешена ли данная благодарность
	$status = thanks_check($user, $usr['id'], $ext, $item);
	switch ($status) {
		case THANKS_ERR_MAXDAY:
			header('403 Forbidden');
			cot_error('thanks_err_maxday');
			break;
		case THANKS_ERR_MAXUSER:
			header('403 Forbidden');
			cot_error('thanks_err_maxuser');
			break;
		case THANKS_ERR_ITEM:
			header('403 Forbidden');
			cot_error('thanks_err_item');
			break;
		// Все в порядке
		case THANKS_ERR_NONE:
			thanks_add($user, $usr['id'], $ext, $item);
			cot_message('thanks_done');
			break;
	}
	// В зависимости от настройки, откроем страницу с сообщением или сразу перенаправим на исходную
	if (Cot::$cfg['plugin']['thanks']['page_on_result']) {
		$t = new XTemplate(cot_tplfile('thanks.done', 'plug'));
		$t->assign(array(
			'THANKS_BACK_URL' => $_SERVER['HTTP_REFERER']
		));
		cot_display_messages($t);
	} else {
		cot_redirect($_SERVER['HTTP_REFERER']);
	}
} elseif ($a == 'viewdetails') {
	$t = new XTemplate(cot_tplfile('thanks', 'plug'));
	$crumbs[] = array(cot_url('thanks'), Cot::$L['thanks_title_short']);
	$crumbs[] = Cot::$db->query("SELECT user_name FROM $db_users WHERE user_id = $user")->fetchColumn();
	$t->assign(array(
  	'THANKS_TITLE' => $L['thanks_title_user'],
  	'THANKS_BREADCRUMBS' => cot_breadcrumbs($crumbs, Cot::$cfg['homebreadcrumb']),
		'THANKS_LIST' => thanks_render_user('thanks.user', Cot::$cfg['plugin']['thanks']['thanksperpage'], '', '', $user, 'page'),
	));
} elseif (!$a) {
	$t = new XTemplate(cot_tplfile('thanks', 'plug'));
	$crumbs[] = Cot::$L['thanks_title_short'];
	$t->assign(array(
  	'THANKS_TITLE' => $L['thanks_title'],
  	'THANKS_BREADCRUMBS' => cot_breadcrumbs($crumbs, Cot::$cfg['homebreadcrumb']),
  	'THANKS_LIST' => thanks_render_list('thanks.list', Cot::$cfg['plugin']['thanks']['usersperpage'], '', '', '', 'page'),
	));
}
