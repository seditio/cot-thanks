<?php

/**
 * Thanks / Resources
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$R['thanks_divider'] = ', ';

$R['thanks_bracket_open'] = ' (';
$R['thanks_bracket_close'] = ')';

$R['thanks_quote_open'] = '&laquo;';
$R['thanks_quote_close'] = '&raquo;';

$R['thanks_class_list'] = '';

$R['thanks_pm_notification']   = '{$intro} <br /> <a href="{$link}">' . $L['ReadMore'] . '</a>';
$R['thanks_email_notification']   = '{$intro}
{$link}';

if (cot_plugin_active('icons')) {
  $R['more_back']   = '<a href="{$link}" class="btn btn-sm btn-secondary">' . $R['icon-arrow-right'] . '<span>' . $L['ReadMore'] . '</span></a>';
  $R['delete_back']   = '<a href="{$link}" class="btn btn-sm btn-danger confirmLink">' . $R['icon-trash'] . '<span>' . $L['Delete'] . '</span></a>';
} else {
  $R['more_back']   = '<a href="{$link}" class="btn btn-sm btn-secondary"> >> <span>' . $L['ReadMore'] . '</span></a>';
  $R['delete_back']   = '<a href="{$link}" class="btn btn-sm btn-danger confirmLink"> x <span>' . $L['Delete'] . '</span></a>';
}

$R['more_front']   = '<a href="{$link}" class="{$class}">' . $L['More'] . '</a>';
