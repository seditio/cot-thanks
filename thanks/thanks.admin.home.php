<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home
[END_COT_EXT]
==================== */

/**
 * Thanks Admin Home
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$is_backend = true;

include_once cot_langfile('thanks', 'plug');
include_once cot_incfile('thanks', 'plug');
include_once cot_incfile('thanks', 'plug', 'api');
require_once cot_incfile('thanks', 'plug', 'resources');
