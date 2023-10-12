<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=thanks.user.loop
[END_COT_EXT]
==================== */

/**
 * Thanks thanks.user.loop
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
    'PAGE_ROW_TITLE'			=> Cot::$L['Page'] . ": " . htmlspecialchars($row['page_title']),
    'PAGE_ROW_URL'				=> cot_page_url(array('page_cat' => $row['page_cat'], 'page_id' => $row['page_id'], 'page_alias' => $row['page_alias'])),
    'PAGE_ROW_CAT_LINK'		=> cot_rc_link(cot_url('page', 'c=' . $row['page_cat']), htmlspecialchars(Cot::$structure['page'][$row['page_cat']]['title'])),
  ));

} elseif ($forums_on && !empty($row['ft_title'])) {
  // Это благодарность к посту
  $t->assign(array(
    'PAGE_ROW_TITLE'			=> Cot::$L['thanks_post_in_topic'] . ": " . htmlspecialchars($row['ft_title']),
    'PAGE_ROW_URL'				=> cot_url('forums', 'm=posts&id=' . $row['th_item']),
    'PAGE_ROW_CAT_LINK'		=> cot_rc_link(cot_url('forums', 'm=topics&s=' . $row['fp_cat']), htmlspecialchars(Cot::$structure['forums'][$row['fp_cat']]['title'])),
  ));

} elseif ($comments_on && !empty($row['com_author'])) {
  // Это благодарность к комментарию
  // ... для страницы
  if ($row['p2_title']) {
    $urlp = empty($row['p2_alias']) ? array('c' => $row['p2_cat'], 'id' => $row['p2_id']) : array('c' => $row['p2_cat'], 'al' => $row['p2_alias']);
    $prt = Cot::$L['thanks_comment_to_page'] . ": " . htmlspecialchars($row['p2_title']);
    $pru = cot_url($row['com_area'], $urlp, '#c' . $row['th_item']);
    $prl = cot_rc_link(cot_url('page', 'c=' . $row['p2_cat']), htmlspecialchars(Cot::$structure['page'][$row['p2_cat']]['title']));
  // ... для опроса
  } elseif ($row['pl2_text']) {
    include_once cot_langfile('thanks', 'plug');
    $prt = Cot::$L['thanks_comment_to_poll'] . ": " . htmlspecialchars($row['pl2_text']);
    $pru = cot_url($row['com_area'], array('id' => $row['pl2_id']), '#c' . $row['th_item']);
    $prl = Cot::$L['thanks_no_category'];
  }

  $t->assign(array(
    'PAGE_ROW_TITLE'			=> $prt,
    'PAGE_ROW_URL'				=> $pru,
    'PAGE_ROW_CAT_LINK'		=> $prl,
  ));
}
