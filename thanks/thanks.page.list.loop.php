<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.list.loop
Tags=page.list.tpl:{LIST_ROW_THANKS_COUNT}
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

if (Cot::$cfg['plugin']['thanks']['page_list']) {
	require_once cot_incfile('thanks', 'plug', 'api');
	$t->assign('LIST_ROW_THANKS_COUNT', thanks_count('page', $pag['page_id']));
}
