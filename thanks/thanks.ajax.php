<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

/**
 * Thanks Ajax
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/* === Hook === */
foreach (array_merge(cot_getextplugins('thanks.ajax.first')) as $pl) {
  include $pl;
}
/* ===== */

if (Cot::$cfg['plugin']['thanks']['encrypt_ajax_urls'] == 1) {
  $params = cot_import('h', 'G', 'TXT');
  $params = sedby_encrypt_decrypt('decrypt', $params, Cot::$cfg['plugin']['thanks']['encrypt_key'], Cot::$cfg['plugin']['thanks']['encrypt_iv']);
  $params = explode(',', $params);

  $tpl = $params[0];
  $items = $params[1];
  $order = $params[2];
  $extra = $params[3];
  $user = $params[4];
  $pagination = $params[5];
  $ajax_block = $params[6];
  $cache_name = $params[7];
  $cache_ttl = $params[8];
  $area = $params[9];
}
else {
  $tpl = cot_import('tpl','G','TXT');
  $items = cot_import('items','G','INT');
  $order = cot_import('order','G','TXT');
  $extra = cot_import('extra','G','TXT');
  $user = cot_import('user','G','INT');
  $pagination = cot_import('pagination','G','TXT');
  $ajax_block = cot_import('ajax_block','G','TXT');
  $cache_name = cot_import('cache_name','G','TXT');
  $cache_ttl = cot_import('cache_ttl','G','INT');
  $area = cot_import('area','G','TXT');
}

ob_clean();
if ($area == 'list') {
  echo thanks_render_list($tpl, $items, $order, $extra, $user, $pagination, $ajax_block, $cache_name, $cache_ttl);
} elseif ($area == 'user') {
  echo thanks_render_user($tpl, $items, $order, $extra, $user, $pagination, $ajax_block, $cache_name, $cache_ttl);
}
ob_flush();
exit;
