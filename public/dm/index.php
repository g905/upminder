<?php

/* Алмазная картина по фото */

define('_SY', true);

/* Подключаем необходимые для работы файлы системы */
if (!file_exists('config.php')) {
	die('Отсутствует config.php');
}
if (!file_exists('functions.php')) {
	die('Отсутствует functions.php');
}

require_once('config.php');
require_once('functions.php');

/* Основной шаблон */
require_once(_TPL.'home.php');