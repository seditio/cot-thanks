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
$L['cfg_maxday'] = 'Лимит благодарностей в день';
$L['cfg_maxuser'] = 'Лимит благодарностей в день одному получателю';
$L['cfg_maxthanked'] = 'Количество последних поблагодаривших для объекта';
$L['cfg_maxthanked_hint'] = '0 - вывести всех';

$L['cfg_pagination'] = 'Паджинация:';
$L['cfg_usersperpage'] = 'Пользователей на страницу';
$L['cfg_usersperpage_hint'] = 'В общем списке пользователей';
$L['cfg_thanksperpage'] = 'Лайков на страницу';
$L['cfg_thanksperpage_hint'] = 'В списке лайков пользователю';
$L['cfg_ajax'] = 'Использовать AJAX для паджинации';
$L['cfg_encrypt_ajax_urls'] = 'Шифровать URLы AJAX-паджинации';
$L['cfg_encrypt_ajax_urls_hint'] = 'Работает только при включенной AJAX-паджинации, рекомендуется для действующих сайтов в т. ч. при использовании аргумента $extra с AJAX';
$L['cfg_encrypt_key'] = 'Ключ шифрования';
$L['cfg_encrypt_iv'] = 'Вектор исполнения';
$L['cfg_nozero'] = 'Исключить пользователей с нулевым количеством благодарностей';

$L['cfg_page'] = 'Благодарности для страниц:';
$L['cfg_page_on'] = 'Включить';
$L['cfg_page_class'] = 'Класс для ссылок на страницах';

$L['cfg_forums'] = 'Благодарности для форумов (посты):';
$L['cfg_forums_on'] = 'Включить';
$L['cfg_forums_class'] = 'Класс для ссылок в постах';

$L['cfg_comments'] = 'Благодарности для комментариев:';
$L['cfg_comments_on'] = 'Включить';
$L['cfg_comments_class'] = 'Класс для ссылок в комментариях';
$L['cfg_comments_order'] = 'Сортировать комментарии по количеству благодарностей';

$L['cfg_misc'] = 'Разное:';
$L['cfg_short'] = 'Короткая форма вывода поблагодаривших для объекта';
$L['cfg_short_hint'] = 'Только имена (без дат)';
$L['cfg_page_on_result'] = 'После благодарности открыть отдельную страницу';
$L['cfg_page_on_result_hint'] = 'Или обновить исходную';

/**
 * Plugin Body
 */

$L['thanks_title'] = 'Благодарности пользователям';
$L['thanks_title_short'] = 'Благодарности';
$L['thanks_title_user'] = 'Благодарности пользователю';
$L['thanks_title_page'] = 'Лайки странице';
$L['thanks_title_forums'] = 'Лайки посту';
$L['thanks_title_comments'] = 'Лайки комментарию';

$L['thanks_thanked'] = 'Поблагодарили';

// Error Messages

$L['thanks_err_maxday'] = 'Извините, сегодня благодарить больше не получится';
$L['thanks_err_maxuser'] = 'Извините, этого пользователя поблагодарить сегодня снова нельзя';
$L['thanks_err_item'] = 'Извините, нельзя благодарить за один элемент дважды';
$L['thanks_err_self'] = 'Вы не можете поблагодарить себя';
$L['thanks_err_wrong_parameter'] = 'Ошибка в параметре запроса';

$L['thanks_no_auth'] = 'Недостаточно прав';

$L['thanks_done'] = 'Вы поблагодарили автора';

// Misc

$L['thanks_back'] = 'Вернуться';
$L['thanks_for_user'] = 'Благодарности для пользователя';
$L['thanks_thanks'] = 'Сказать спасибо!';
$L['thanks_times'] = 'раз';
$L['thanks_top'] = 'Топ благодарностей пользователям';

$L['thanks_none'] = 'Благодарности отсутствуют';
$L['thanks_users_none'] = 'Пользователи с благодарностями отсутствуют';

$L['thanks_remove_all'] = 'Удалить все благодарности пользователя?';
$L['thanks_remove_one'] = 'Удалить данную благодарность?';

$L['thanks_removed'] = 'Благодарность удалена';
$L['thanks_user_removed'] = 'Все благодарности пользователя удалены';
$L['thanks_user_removed_zero'] = 'Благодарностей пользователя не найдено';
$L['thanks_sync_complete'] = 'Синхронизация завершена';

// ???

$L['thanks_ensure'] = 'Вы хотите поблагодарить этого пользователя?';
$L['thanks_tag'] = 'Пользователь сказал cпасибо: ';
