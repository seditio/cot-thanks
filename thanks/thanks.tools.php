<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
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

include_once cot_langfile('thanks', 'plug');
include_once cot_incfile('thanks', 'plug');
include_once cot_incfile('thanks', 'plug', 'api');
require_once cot_incfile('thanks', 'plug', 'resources');

$thanks_auth_admin = cot_auth('plug', 'thanks', 'A');

$out['subtitle'] = $L['thanks_meta_title'];
$out['desc'] = $L['thanks_meta_desc'];

$ext = cot_import('ext', 'G', 'ALP');
$item = cot_import('item', 'G', 'INT');
$user = cot_import('user', 'G', 'INT');

$t = new XTemplate(cot_tplfile('thanks.tools', 'plug', true));

$is_backend = true;

if ($a == 'viewdetails' && (int)$user > 0) {
	$t->assign(array(
		'THANKS_TITLE' => $L['thanks_title_short'],
		'THANKS_LIST' => thanks_render_user('thanks.user', Cot::$cfg['plugin']['thanks']['thanksperpage'], '', '', $user, 'page'),
	));
} elseif ($a == 'remove' && (int)$user > 0 && (int)$item > 0) {
	if ($thanks_auth_admin) {
		thanks_remove($item);
		cot_redirect(cot_url('admin', 'm=other&p=thanks&a=viewdetails&user=' . $user, '', true));
	} else {
		cot_message('thanks_no_auth', 'danger');
		cot_redirect(cot_url('index'));
	}
} elseif ($a == 'removeall' && (int)$user > 0) {
	if ($thanks_auth_admin) {
		thanks_remove_user($user);
		cot_redirect(cot_url('admin', 'm=other&p=thanks', '', true));
	} else {
		cot_message('thanks_no_auth', 'danger');
		cot_redirect(cot_url('index'));
	}
} elseif ($a == 'sync') {
	if ($thanks_auth_admin) {
		thanks_sync();
		cot_redirect(cot_url('admin', 'm=other&p=thanks', '', true));
	} else {
		cot_message('thanks_no_auth', 'danger');
		cot_redirect(cot_url('index'));
	}
} elseif (!$a) {
	$t->assign(array(
  	'THANKS_TITLE' => $L['thanks_title_short'],
  	'THANKS_LIST' => thanks_render_list('thanks.list', Cot::$cfg['plugin']['thanks']['usersperpage'], '', '', '', 'page'),
	));
}

cot_display_messages($t);

$t->parse('MAIN');
if (COT_AJAX) {
	$t->out('MAIN');
} else {
	$adminmain = $t->text('MAIN');
}
