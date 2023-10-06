<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.query
[END_COT_EXT]
==================== */

/**
 * Thanks comments query
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (Cot::$cfg['plugin']['thanks']['comments_on']) {

	Cot::$db->registerTable('thanks');
	$db_thanks = Cot::$db->thanks;

	$comments_join_columns .= ", (SELECT COUNT(*) FROM `$db_thanks` WHERE th_ext = 'comments' AND th_item = c.com_id) AS thanks_count";

	if ($usr['id'] > 0 && cot_auth('plug', 'thanks', 'W')) {
		$comments_join_columns .= ", (SELECT COUNT(*) FROM `$db_thanks` WHERE `th_fromuser` = {$usr['id']} AND `th_touser` = c.com_authorid AND DATE(`th_date`) = DATE(NOW())) AS thanks_touser_today
			, (SELECT COUNT(*) FROM `$db_thanks` WHERE `th_fromuser` = {$usr['id']} AND `th_ext` = 'comments' AND `th_item` = c.com_id) AS thanks_toitem";
	}

	if (Cot::$cfg['plugin']['thanks']['comments_order']) {
		$comments_order = "thanks_count DESC, " . $comments_order;
	}

}
