<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=thanks.user.query
[END_COT_EXT]
==================== */

/**
 * Thanks thanks.user.query
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (cot_module_active('page') && Cot::$cfg['plugin']['thanks']['page_on']) {
	$page_on = true;
	require_once cot_incfile('page', 'module');
	$thanks_join_columns .= ", pag.page_id, pag.page_alias, pag.page_title, pag.page_cat ";
	$thanks_join_tables .= " LEFT JOIN $db_pages AS pag ON t.th_ext = 'page' AND t.th_item = pag.page_id ";
}

if (cot_module_active('forums') && Cot::$cfg['plugin']['thanks']['forums_on']) {
	$forums_on = true;
	require_once cot_incfile('forums', 'module');
	$thanks_join_columns .= ", fp.fp_cat, ft.ft_title ";
	$thanks_join_tables .= " LEFT JOIN $db_forum_posts AS fp ON t.th_ext = 'forums' AND t.th_item = fp.fp_id ";
	$thanks_join_tables .= " LEFT JOIN $db_forum_topics AS ft ON fp.fp_id > 0 AND fp.fp_topicid = ft.ft_id ";
}

if (cot_plugin_active('comments') && Cot::$cfg['plugin']['thanks']['comments_on']) {
	$comments_on = true;
	require_once cot_incfile('comments', 'plug');
	$thanks_join_columns .= ", com.*, pag2.page_alias AS p2_alias, pag2.page_id AS p2_id, pag2.page_cat AS p2_cat, pag2.page_title AS p2_title ";
	$thanks_join_tables .= " LEFT JOIN $db_com AS com ON t.th_ext = 'comments' AND t.th_item = com.com_id LEFT JOIN $db_pages AS pag2 ON com.com_area = 'page' AND com.com_code = pag2.page_id ";
}

// $thanks_join_columns .= ", fu.user_name ";
// $thanks_join_tables .= " LEFT JOIN $db_users AS fu ON t.th_fromuser = fu.user_id ";
