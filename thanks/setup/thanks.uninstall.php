<?php
/**
 * Thanks uninstallation handler
 *
 * @package thanks
 * @version 1.0
 * @author Trustmaster
 * @copyright Copyright (c) Vladimir Sibirov 2011
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users;
$db->query("ALTER TABLE $db_users DROP COLUMN `user_thanks`");
