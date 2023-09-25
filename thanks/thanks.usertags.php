<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=usertags.main
[END_COT_EXT]
==================== */

/**
 * Thanks user tags
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

static $th_lang_loaded = false;

if (!$th_lang_loaded) {
	require_once cot_langfile('thanks', 'plug');
	$th_lang_loaded = true;
}

$temp_array['THANKS'] = $user_data['user_thanks'];
$temp_array['THANKS_URL'] = cot_url('thanks', 'user=' . $user_data['user_id']);
$temp_array['THANKS_TIMES'] = cot_declension($user_data['user_thanks'], 'Times');
