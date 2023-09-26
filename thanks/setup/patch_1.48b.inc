<?php
defined('COT_CODE') or die('Wrong URL');

global $db_thanks;

if (empty($db_thanks)) {
  // Registering tables
  Cot::$db->registerTable('thanks');
}

Cot::$db->query("ALTER TABLE `{$db_thanks}` ADD COLUMN `th_date_new` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `th_date`, ENGINE=InnoDB;");
Cot::$db->query("UPDATE `{$db_thanks}` SET `th_date_new` = UNIX_TIMESTAMP(`th_date`)");
Cot::$db->query("ALTER TABLE `{$db_thanks}` DROP COLUMN `th_date`");
Cot::$db->query("ALTER TABLE `{$db_thanks}` CHANGE `th_date_new` `th_date` INT(10)");

$changeCollation = false;
if (
    Cot::$cfg['mysqlcharset'] == 'utf8mb4' &&
    (empty(Cot::$cfg['mysqlcollate']) || Cot::$cfg['mysqlcollate'] == 'utf8mb4_unicode_ci')
) {
    $changeCollation = true;
}

if ($changeCollation) {
    Cot::$db->query("ALTER TABLE `{$db_thanks}`
    CONVERT TO CHARACTER SET '" . Cot::$cfg['mysqlcharset'] . "' COLLATE '" . Cot::$cfg['mysqlcollate'] . "',
    DEFAULT CHARACTER SET='" . Cot::$cfg['mysqlcharset'] . "' COLLATE='" . Cot::$cfg['mysqlcollate'] . "'");
}
