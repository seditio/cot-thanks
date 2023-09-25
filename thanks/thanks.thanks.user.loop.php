<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=thanks.user.loop
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

if ($page_on && !empty($row['page_title'])) {
  // Это благодарность к странице
  $t->assign(array(
    'PAGE_ROW_TITLE'			=> htmlspecialchars($row['page_title']),
    'PAGE_ROW_URL'				=> cot_page_url(array('page_cat' => $row['page_cat'], 'page_id' => $row['page_id'], 'page_alias' => $row['page_alias'])),
    'PAGE_ROW_CAT_TITLE'	=> htmlspecialchars(Cot::$structure['page'][$row['page_cat']]['title']),
    'PAGE_ROW_CAT_URL'		=> cot_url('page', 'c=' . $row['page_cat']),
  ));

} elseif ($forums_on && !empty($row['ft_title'])) {
  // Это благодарность к посту
  $t->assign(array(
    'PAGE_ROW_TITLE'			=> htmlspecialchars($row['ft_title']),
    'PAGE_ROW_URL'				=> cot_url('forums', 'm=posts&id=' . $row['th_item']),
    'PAGE_ROW_CAT_TITLE'	=> htmlspecialchars(Cot::$structure['forums'][$row['fp_cat']]['title']),
    'PAGE_ROW_CAT_URL'		=> cot_url('forums', 'm=topics&s=' . $row['fp_cat']),
  ));

} elseif ($comments_on && !empty($row['com_author'])) {
  // Это благодарность к комментарию
  $urlp = empty($row['p2_alias']) ? array('c' => $row['p2_cat'], 'id' => $row['p2_id']) : array('c' => $row['p2_cat'], 'al' => $row['p2_alias']);
  $t->assign(array(
    'PAGE_ROW_TITLE'			=> Cot::$L['comments_comment'] . ": " . htmlspecialchars($row['p2_title']),
    'PAGE_ROW_URL'				=> cot_url($row['com_area'], $urlp, '#c' . $row['th_item']),
    'PAGE_ROW_CAT_TITLE'	=> htmlspecialchars(Cot::$structure['page'][$row['p2_cat']]['title']),
    'PAGE_ROW_CAT_URL'		=> cot_url('page', 'c='.$row['p2_cat']),
  ));
}
