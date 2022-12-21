<?php

/* Алмазная картина по фото. Конфигурация */
if (!defined('_SY')) {
	die();
}

/* Дебаг */
define('_SY_DEBUG', true);
if (_SY_DEBUG) {
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

}

/* Главный URL */
define('_HOME', 'http://indesiv4.beget.tech/dm/');

/* Пути к директориям системы */
define('_ROOT', dirname(__FILE__).'/');
define('_INC', _ROOT.'includes/');
define('_TPL', _ROOT.'tpl/');
define('_UPLOADS', _ROOT.'uploads/');

/* Путь к папке для загрузки изначальных изображений */
define('_STARTERS_DIR', _UPLOADS.'starters/');
define('_STARTERS_URL', _HOME.'uploads/starters/');