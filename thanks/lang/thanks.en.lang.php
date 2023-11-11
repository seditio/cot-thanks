<?php
/**
 * Thanks / EN Locale
 *
 * @package thanks
 * @version 2.00b
 * @author Trustmaster & Dmitri Beliavski
 * @copyright Copyright (c) Vladimir Sibirov, Dmitri Beliavski 2011-2023
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/**
 * Plugin Info
 */

$L['info_name'] = 'Thanks';
$L['info_desc'] = 'Enable thanks for a user';
$L['info_notes'] = '';

$L['thanks_meta_title'] = 'User thanks';
$L['thanks_meta_desc'] = 'List of registered users with the number of thanks (likes)';

/**
 * Plugin Config
 */

$L['cfg_limits'] = 'Limits:';
$L['cfg_maxday'] = 'Thanks per day';
$L['cfg_maxuser'] = 'Daily limit of thanks for a user';
$L['cfg_maxthanked'] = 'Number of users that liked an object';
$L['cfg_maxthanked_hint'] = '0 - show all';

$L['cfg_pagination'] = 'Pagination:';
$L['cfg_usersperpage'] = 'Users per page';
$L['cfg_usersperpage_hint'] = 'In the users list';
$L['cfg_thanksperpage'] = 'Likes per page';
$L['cfg_thanksperpage_hint'] = 'In the likes list';
$L['cfg_ajax'] = 'Use AJAX for pagination';
$L['cfg_encrypt_ajax_urls'] = 'Encrypt AJAX pagination URLs';
$L['cfg_encrypt_ajax_urls_hint'] = 'Works only when AJAX pagination is on, recommended for live projects esp. when using $extra argument with AJAX';
$L['cfg_encrypt_key'] = 'Secret key';
$L['cfg_encrypt_iv'] = 'Initialization vector';
$L['cfg_nozero'] = 'Show users with non-zero number of thanks only';

$L['cfg_page'] = 'Page thanks:';
$L['cfg_page_on'] = 'Enable';
$L['cfg_page_class'] = 'CSS-class for links';
$L['cfg_page_list'] = 'Build tags for page lists';

$L['cfg_forums'] = 'Forum thanks (posts):';
$L['cfg_forums_on'] = 'Enable';
$L['cfg_forums_class'] = 'CSS-class for links';

$L['cfg_comments'] = 'Comment thanks:';
$L['cfg_comments_on'] = 'Enable';
$L['cfg_comments_class'] = 'CSS-class for links';
$L['cfg_comments_order'] = 'Sort comments by number of thanks';

$L['cfg_notifications'] = 'Alerts:';
$L['cfg_notify_from'] = 'Sender email';
$L['cfg_notify_by_email'] = 'Send new thanks alerts by email';
$L['cfg_notify_by_pm'] = 'Send new thanks alerts by pm';

$L['cfg_misc'] = 'Misc:';
$L['cfg_short'] = 'Short list of thankers';
$L['cfg_short_hint'] = 'Only names (w/o dates)';
$L['cfg_page_on_result'] = 'Open extra page on successful thank';
$L['cfg_page_on_result_hint'] = 'Or refresh source page';

/**
 * Plugin Body
 */

$L['thanks_title'] = 'Thanks for users';
$L['thanks_title_short'] = 'Thanks';
$L['thanks_title_user'] = 'Thanks for user';
$L['thanks_title_page'] = 'Page thanks';
$L['thanks_title_forums'] = 'Post thanks';
$L['thanks_title_comments'] = 'Comment thanks';

$L['thanks_in_topic'] = 'in the topic';
$L['thanks_for_page'] = 'for the page';
$L['thanks_for_poll'] = 'for the poll';

$L['thanks_post'] = 'Post';
$L['thanks_topic'] = 'Topic';
$L['thanks_post_in_topic'] = 'Post in topic';

$L['thanks_comment_to_page'] = 'Comment to page';
$L['thanks_comment_to_poll'] = 'Comment to poll';

$L['thanks_no_category'] = 'Category missing';

$L['thanks_thanked'] = 'Thanked';

$L['thanks_fullsync'] = 'Full sync';
$L['thanks_fullsync_complete'] = 'Full sync complete';
$L['thanks_fullsync_complete_0'] = 'Full sync complete, no problems detected';
$L['thanks_fullsync_complete_1'] = 'Full sync complete, illegal thanks detected';

// Error Messages

$L['thanks_err_maxday'] = 'Sorry, you can not give any more thanks today';
$L['thanks_err_maxuser'] = 'Sorry, this users can not be thanks today anymore';
$L['thanks_err_item'] = 'Sorry, you can not thank for one object twice';
$L['thanks_err_self'] = 'You can not thank yourself';
$L['thanks_err_wrong_parameter'] = 'Wrong parameter';

$L['thanks_no_auth'] = 'No enough user rights';

$L['thanks_done'] = 'You have thanked the author';

// Misc

$L['thanks_back'] = 'Back';
$L['thanks_for_user'] = 'Thanks for user';
$L['thanks_thanks'] = 'Say thanks!';
$L['thanks_times'] = 'times';
$L['thanks_top'] = 'Top thanks for users';

$L['thanks_none'] = 'No thanks present';
$L['thanks_users_none'] = 'users with thanks missing';

$L['thanks_remove_all'] = 'Delete all user thanks?';
$L['thanks_remove_one'] = 'Delete the thank?';

$L['thanks_removed'] = 'Thank deleted';
$L['thanks_user_removed'] = 'All user thanks deleted';
$L['thanks_user_removed_zero'] = 'No user thanks found';
$L['thanks_sync_complete'] = 'Thanks qty sync complete';

// Notifications

$L['thanks_subject'] = 'You have been thanked!';
$L['thanks_body'] = 'You have been thanked for the post:';

// ???

$L['thanks_ensure'] = 'Would you like to thank the user?';
$L['thanks_tag'] = 'User thanked: ';
