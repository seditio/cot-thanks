<?php
/**
 * Thanks / RU Locale
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
$L['info_desc'] = 'Плагин благодарностей';
$L['info_notes'] = '';

$L['thanks_meta_title'] = 'Благодарности для пользователя';
$L['thanks_meta_desc'] = 'Благодарности для пользователя';

/**
 * Plugin Config
 */

$L['cfg_limits'] = 'Ограничения:';
$L['cfg_maxday'] = 'Макс. благодарностей для раздачи в день';
$L['cfg_maxuser'] = 'Макс. благодарностей в день 1 получателю';

$L['cfg_pagination'] = 'Паджинация:';
$L['cfg_useajax'] = 'Использовать Аякс для паджинации';
$L['cfg_comorder'] = 'Сортировать комментарии по количеству благодарностей';
$L['cfg_nozero'] = 'Исключить из списков пользователей с нулевым количеством благодарностей';

$L['cfg_page'] = 'Благодарности для страниц:';
$L['cfg_page_on'] = 'Включить';
$L['cfg_page_class'] = 'Класс для ссылок на страницах';

$L['cfg_forums'] = 'Благодарности для форумов (посты):';
$L['cfg_forums_on'] = 'Включить';
$L['cfg_forums_class'] = 'Класс для ссылок в постах';

$L['cfg_comments'] = 'Благодарности для комментариев:';
$L['cfg_comments_on'] = 'Включить';
$L['cfg_comments_class'] = 'Класс для ссылок в комментариях';

$L['cfg_misc'] = 'Разное:';
$L['cfg_short'] = 'Короткая форма записи поблагодаривших в списках - только имя (без даты)';
$L['cfg_page_on_result'] = 'После благодарности открыть отдельную страницу';
$L['cfg_page_on_result_hint'] = 'Или обновить исходную';



/**
 * Plugin Body
 */

$L['thanks_title'] = 'Благодарности пользователям';
$L['thanks_title_short'] = 'Благодарности';
$L['thanks_title_user'] = 'Благодарности пользователю';






// Error Messages

$L['thanks_err_maxday'] = 'Извините, сегодня благодарить больше не получится';
$L['thanks_err_maxuser'] = 'Извините, этого пользователя поблагодарить сегодня снова нельзя';
$L['thanks_err_item'] = 'Извините, нельзя благодарить за один элемент дважды';
$L['thanks_err_self'] = 'Вы не можете поблагодарить себя';

$L['thanks_no_auth'] = 'Недостаточно прав';

$L['thanks_done'] = 'Вы поблагодарили автора';

// Misc

$L['thanks_back'] = 'Вернуться';
$L['thanks_for_user'] = 'Благодарности для пользователя';
$L['thanks_thanks'] = 'Сказать спасибо!';
$L['thanks_times'] = 'раз';
$L['thanks_top'] = 'Топ благодарностей пользователям';

$L['thanks_none'] = 'Благодарности отсутствуют';

$L['thanks_remove_all'] = 'Удалить все благодарности пользователя?';
$L['thanks_remove_one'] = 'Удалить данную благодарность?';

$L['thanks_removed'] = 'Благодарность удалена';
$L['thanks_user_removed'] = 'Все благодарности пользователя удалены';
$L['thanks_user_removed_zero'] = 'Благодарностей пользователя не найдено';
$L['thanks_sync_complete'] = 'Синхронизация завершена';

// ???

$L['thanks_ensure'] = 'Вы хотите поблагодарить этого пользователя?';
$L['thanks_thanked'] = 'Поблагодарили';
$L['thanks_tag'] = 'Пользователь сказал cпасибо: ';
