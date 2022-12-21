-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 21 2022 г., 23:31
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `indesiv4_ment`
--

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_type_id` int(11) NOT NULL,
  `mentor_id` int(11) DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `communicate_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose_mentoring` text COLLATE utf8mb4_unicode_ci,
  `language_id` int(11) DEFAULT NULL,
  `promo_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Часовой пояс',
  `law_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_checked` tinyint(1) NOT NULL DEFAULT '0',
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resume_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `mentor_service_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `application_mentor_tags`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `application_mentor_tags`;
CREATE TABLE `application_mentor_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` int(11) NOT NULL,
  `mentor_tag_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `application_types`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `application_types`;
CREATE TABLE `application_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `short_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `category_tags`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `category_tags`;
CREATE TABLE `category_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_filter` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category_tags`
--

INSERT INTO `category_tags` (`id`, `category_id`, `name`, `is_filter`, `created_at`, `updated_at`) VALUES
(1, 2, 'Анимация', 0, '2022-12-11 10:08:46', '2022-12-11 10:08:46'),
(2, 2, 'Parallax', 0, '2022-12-11 10:08:56', '2022-12-11 10:08:56'),
(3, 3, 'Обучение PHP', 1, '2022-12-12 14:13:17', '2022-12-12 14:13:17'),
(4, 2, 'Управление', 0, '2022-12-13 09:42:05', '2022-12-13 09:42:05'),
(5, 2, 'Исправление', 0, '2022-12-13 09:42:16', '2022-12-13 09:42:16'),
(6, 3, 'программирование PHP', 0, '2022-12-13 10:09:55', '2022-12-13 10:09:55');

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Москва', '2022-12-11 10:12:02', '2022-12-11 10:12:02'),
(2, 1, 'Санкт-Петербург', '2022-12-11 10:12:11', '2022-12-11 10:12:11'),
(3, 2, 'Киев', '2022-12-11 10:12:18', '2022-12-11 10:12:18'),
(4, 2, 'Харьков', '2022-12-11 10:12:24', '2022-12-11 10:12:24');

-- --------------------------------------------------------

--
-- Структура таблицы `companies`
--
-- Создание: Дек 14 2022 г., 17:36
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `law_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `companies`
--

INSERT INTO `companies` (`id`, `country_id`, `city_id`, `name`, `law_name`, `inn`, `contact_name`, `email`, `phone`, `website`, `description`, `logo`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'ООО \"НьюСервис\"', 'ООО \"НьюСервис\"', '123123123', '123', NULL, NULL, NULL, '123', NULL, '2022-12-13 02:49:11', '2022-12-13 02:49:11'),
(6, 1, 1, 'Тестовая12', 'Еще', '123123', '123', '321@mail.ru', '123', '321', '123', '785087.jpg', '2022-12-14 14:52:39', '2022-12-14 15:10:36'),
(7, NULL, NULL, 'название2', '5345345345', '3345345', NULL, NULL, NULL, NULL, NULL, '477960.png', '2022-12-14 15:09:53', '2022-12-14 15:11:36'),
(8, NULL, NULL, '23423423', '234234234', '4234234234', NULL, NULL, NULL, NULL, NULL, '548257.jpg', '2022-12-14 15:12:06', '2022-12-15 15:23:10');

-- --------------------------------------------------------

--
-- Структура таблицы `company_categories`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `company_categories`;
CREATE TABLE `company_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `company_categories`
--

INSERT INTO `company_categories` (`id`, `parent_id`, `name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Веб-разработка', '2022-12-13 02:48:48', '2022-12-13 02:48:48');

-- --------------------------------------------------------

--
-- Структура таблицы `company_single_categories`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `company_single_categories`;
CREATE TABLE `company_single_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `company_single_categories`
--

INSERT INTO `company_single_categories` (`id`, `company_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2022-12-13 02:49:11', '2022-12-13 02:49:11'),
(2, 2, 1, '2022-12-14 14:16:45', '2022-12-14 14:16:45'),
(3, 3, 1, '2022-12-14 14:38:56', '2022-12-14 14:38:56'),
(4, 4, 1, '2022-12-14 14:45:01', '2022-12-14 14:45:01'),
(5, 5, 1, '2022-12-14 14:51:17', '2022-12-14 14:51:17'),
(6, 6, 1, '2022-12-14 14:52:39', '2022-12-14 14:52:39');

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Россия', '2022-12-11 10:11:35', '2022-12-11 10:11:35'),
(2, 'Украина', '2022-12-11 10:11:41', '2022-12-11 10:11:41');

-- --------------------------------------------------------

--
-- Структура таблицы `currencies`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'rub', 'Российский рубль', NULL, NULL),
(2, 'usd', 'Доллар США', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `languages`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `lessons`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date_start` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NULL DEFAULT NULL,
  `price` double NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mentors`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `mentors`;
CREATE TABLE `mentors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `help_text` longtext COLLATE utf8mb4_unicode_ci,
  `experience` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Часовой пояс',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `vip_status` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mentors`
--

INSERT INTO `mentors` (`id`, `avatar`, `country_id`, `city_id`, `last_name`, `first_name`, `surname`, `email`, `phone`, `telegram`, `description`, `help_text`, `experience`, `timezone`, `verified`, `vip_status`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'avatar_16707642526395d6dc085dd.jpg', 1, 2, 'Петренко', 'Олег', 'Иванович', 'sidorow@mail.ru', '123123', '123321', 'Более 6-ти лет занимаюсь голосовыми сервисами и корпоративной телефонии. Практически с самого начала администрировал сервисы на платформе Avaya Aura, но также приходилось внедрять и управлять Oktell и', 'Всем :)', NULL, NULL, 0, 0, 1, '2022-12-11 10:10:52', '2022-12-14 16:40:15'),
(2, 'avatar_16707647106395d8a606e64.jpg', 1, 1, 'Атрощенко', 'Олеся', 'Иванович', 'sidorov@mail.ru', '123456', '@654321', 'Более 6-ти лет занимаюсь голосовыми сервисами и корпоративной телефонии. Практически с самого начала администрировал сервисы на платформе Avaya Aura, но также приходилось внедрять и управлять Oktell и', 'Да впринципе любая задача в CSS решаема', NULL, NULL, 0, 0, 1, '2022-12-11 10:18:30', '2022-12-14 16:40:53'),
(3, 'avatar_16709065186398029660a91.jpg', 1, 1, 'Сидоров', 'Антон', 'Иванович', 'sidorov@mail.ru', '123456', '@654321', 'Более 6-ти лет занимаюсь голосовыми сервисами и корпоративной телефонии. Практически с самого начала администрировал сервисы на платформе Avaya Aura, но также приходилось внедрять и управлять Oktell и', 'Да впринципе любая задача в CSS решаема', '5 лет', NULL, 1, 1, 1, '2022-12-11 10:21:00', '2022-12-14 16:38:59');

-- --------------------------------------------------------

--
-- Структура таблицы `mentor_categories`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `mentor_categories`;
CREATE TABLE `mentor_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mentor_categories`
--

INSERT INTO `mentor_categories` (`id`, `parent_id`, `name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'IT', '2022-12-11 10:04:30', '2022-12-11 10:04:30'),
(2, 1, 'CSS', '2022-12-11 10:04:37', '2022-12-11 10:04:37'),
(3, 1, 'PHP', '2022-12-11 10:04:47', '2022-12-11 10:04:47');

-- --------------------------------------------------------

--
-- Структура таблицы `mentor_metas`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `mentor_metas`;
CREATE TABLE `mentor_metas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `property` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mentor_services`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `mentor_services`;
CREATE TABLE `mentor_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_service` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mentor_services`
--

INSERT INTO `mentor_services` (`id`, `type_service`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Вебинар', '2022-12-11 10:05:05', '2022-12-11 10:05:05'),
(2, 1, 'Правка CSS', '2022-12-11 10:05:27', '2022-12-11 10:05:27'),
(3, 1, 'Наполнение сайта', '2022-12-13 09:38:59', '2022-12-13 09:38:59'),
(4, 1, 'Управление маркетингом', '2022-12-13 09:39:10', '2022-12-13 09:39:10'),
(5, 2, 'Услуга дополнительная', '2022-12-13 09:40:22', '2022-12-13 09:40:22'),
(6, 2, 'Создание логотипа', '2022-12-13 09:40:41', '2022-12-13 09:40:41');

-- --------------------------------------------------------

--
-- Структура таблицы `mentor_single_categories`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `mentor_single_categories`;
CREATE TABLE `mentor_single_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mentor_single_categories`
--

INSERT INTO `mentor_single_categories` (`id`, `mentor_id`, `category_id`, `created_at`, `updated_at`) VALUES
(54, 3, 2, '2022-12-14 16:38:59', '2022-12-14 16:38:59'),
(55, 1, 3, '2022-12-14 16:40:15', '2022-12-14 16:40:15'),
(62, 2, 2, '2022-12-14 16:44:20', '2022-12-14 16:44:20'),
(63, 2, 3, '2022-12-14 16:44:20', '2022-12-14 16:44:20');

-- --------------------------------------------------------

--
-- Структура таблицы `mentor_single_educations`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `mentor_single_educations`;
CREATE TABLE `mentor_single_educations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `date_present` tinyint(1) NOT NULL DEFAULT '0',
  `school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mentor_single_educations`
--

INSERT INTO `mentor_single_educations` (`id`, `mentor_id`, `date_start`, `date_end`, `date_present`, `school`, `course`, `created_at`, `updated_at`) VALUES
(53, 3, '2022-10-11', '2022-12-10', 0, 'Такое-то', 'Курс такой- то', '2022-12-14 16:38:59', '2022-12-14 16:38:59'),
(54, 1, '2022-12-11', '2022-12-11', 0, 'Такое-то', 'А вот такой-то курс', '2022-12-14 16:40:15', '2022-12-14 16:40:15'),
(58, 2, '2022-10-11', '2022-12-10', 0, 'Такое-то', 'Курс такой- то', '2022-12-14 16:44:20', '2022-12-14 16:44:20');

-- --------------------------------------------------------

--
-- Структура таблицы `mentor_single_experiences`
--
-- Создание: Дек 13 2022 г., 05:48
--

DROP TABLE IF EXISTS `mentor_single_experiences`;
CREATE TABLE `mentor_single_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `date_present` tinyint(1) NOT NULL DEFAULT '0',
  `company_id` int(11) DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mentor_single_experiences`
--

INSERT INTO `mentor_single_experiences` (`id`, `mentor_id`, `date_start`, `date_end`, `date_present`, `company_id`, `position`, `created_at`, `updated_at`) VALUES
(70, 3, '2022-12-11', '2022-12-11', 0, 1, 'Программист', '2022-12-14 16:38:59', '2022-12-14 16:38:59'),
(71, 3, '2008-12-10', '2022-12-10', 1, 6, 'Верстальщик', '2022-12-14 16:38:59', '2022-12-14 16:38:59'),
(72, 1, '2022-12-11', NULL, 0, 1, 'Такая-то', '2022-12-14 16:40:15', '2022-12-14 16:40:15'),
(76, 2, '2022-12-11', '2022-12-11', 0, 1, 'Такая-то', '2022-12-14 16:44:20', '2022-12-14 16:44:20');

-- --------------------------------------------------------

--
-- Структура таблицы `mentor_single_services`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `mentor_single_services`;
CREATE TABLE `mentor_single_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `discount` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mentor_single_services`
--

INSERT INTO `mentor_single_services` (`id`, `mentor_id`, `currency_id`, `service_id`, `price`, `discount`, `created_at`, `updated_at`) VALUES
(118, 3, 1, 2, 1500, 10, '2022-12-14 16:38:59', '2022-12-14 16:38:59'),
(119, 3, 1, 6, 2000, 20, '2022-12-14 16:38:59', '2022-12-14 16:38:59'),
(120, 3, 2, 5, 2000, 10, '2022-12-14 16:38:59', '2022-12-14 16:38:59'),
(121, 1, 1, 2, 2000, 13, '2022-12-14 16:40:15', '2022-12-14 16:40:15'),
(122, 1, 1, 3, 1000, 15, '2022-12-14 16:40:15', '2022-12-14 16:40:15'),
(131, 2, 1, 1, 1500, 0, '2022-12-14 16:44:20', '2022-12-14 16:44:20'),
(132, 2, 1, 2, 500, 0, '2022-12-14 16:44:20', '2022-12-14 16:44:20'),
(133, 2, 2, 6, 1799, 1, '2022-12-14 16:44:20', '2022-12-14 16:44:20'),
(134, 2, 2, 5, 15, 2, '2022-12-14 16:44:20', '2022-12-14 16:44:20');

-- --------------------------------------------------------

--
-- Структура таблицы `mentor_tags`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `mentor_tags`;
CREATE TABLE `mentor_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mentor_tags`
--

INSERT INTO `mentor_tags` (`id`, `tag_id`, `mentor_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, NULL),
(2, 2, 3, NULL, NULL),
(3, 4, 3, NULL, NULL),
(4, 5, 3, NULL, NULL),
(5, 3, 1, NULL, NULL),
(7, 6, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `mentor_weeks`
--
-- Создание: Дек 13 2022 г., 12:38
--

DROP TABLE IF EXISTS `mentor_weeks`;
CREATE TABLE `mentor_weeks` (
  `id` int(11) NOT NULL,
  `date_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mentor_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mentor_weeks`
--

INSERT INTO `mentor_weeks` (`id`, `date_start`, `date_end`, `mentor_id`, `category_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2022-12-13 15:45:00', '2022-12-26 21:46:00', 1, 2, 1, '2022-12-13 13:15:42', '2022-12-13 13:15:42');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(28, '2014_10_12_000000_create_users_table', 1),
(29, '2014_10_12_100000_create_password_resets_table', 1),
(30, '2019_08_19_000000_create_failed_jobs_table', 1),
(31, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(32, '2022_08_10_095550_create_countries_table', 1),
(33, '2022_10_01_000003_create_cities_table', 1),
(34, '2022_10_01_000004_create_companies_table', 1),
(35, '2022_10_01_000005_create_company_categories_table', 1),
(36, '2022_10_01_000006_create_company_single_categories_table', 1),
(37, '2022_10_01_000007_create_languages_table', 1),
(38, '2022_10_01_000008_create_mentors_table', 1),
(39, '2022_10_01_000009_create_mentor_categories_table', 1),
(40, '2022_10_01_000010_create_currencies_table', 1),
(41, '2022_10_01_123459_create_mentor_single_categories_table', 1),
(42, '2022_10_01_123800_create_mentor_single_educations_table', 1),
(43, '2022_10_01_124143_create_mentor_single_experiences_table', 1),
(44, '2022_10_01_124614_create_mentor_services_table', 1),
(45, '2022_10_01_124615_create_mentor_single_services_table', 1),
(46, '2022_10_01_130602_create_mentor_metas_table', 1),
(47, '2022_10_01_131308_create_pages_table', 1),
(48, '2022_10_01_131709_create_reviews_table', 1),
(49, '2022_10_01_132344_create_lessons_table', 1),
(50, '2022_10_07_080533_create_applications_table', 1),
(51, '2022_10_07_081202_create_application_types_table', 1),
(52, '2022_10_07_110934_create_application_mentor_tags_table', 1),
(53, '2022_10_07_123037_create_category_tags_table', 1),
(54, '2022_10_07_123038_create_mentor_tags_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_type` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` longtext COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--
-- Создание: Дек 11 2022 г., 12:59
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT 'Положительный / негативный',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `mentor_id`, `author`, `email`, `text`, `type`, `active`, `created_at`, `updated_at`) VALUES
(1, 3, 'Отзовик', NULL, 'Не следует, однако, забывать, что базовый вектор развития представляет собой интересный эксперимент проверки экспериментов, поражающих по своей масштабности и грандиозности. Как уже неоднократно упомянуто, элементы политического процесса, вне зависимости от их уровня, должны быть разоблачены. Задача организации, в особенности же укрепление и развитие внутренней структуры предопределяет высокую востребованность экономической целесообразности принимаемых решений!', 1, 1, '2022-12-16 09:20:25', '2022-12-16 09:20:25');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
-- Создание: Дек 11 2022 г., 12:59
-- Последнее обновление: Дек 21 2022 г., 18:19
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@upminder.ru', NULL, '$2y$10$QtbfD7feIUknXrb5pQ96GeOznZ5v7yMGv/5Wvac/8IWifgSfEa/J.', NULL, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `application_mentor_tags`
--
ALTER TABLE `application_mentor_tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `application_types`
--
ALTER TABLE `application_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category_tags`
--
ALTER TABLE `category_tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `company_categories`
--
ALTER TABLE `company_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `company_single_categories`
--
ALTER TABLE `company_single_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mentors`
--
ALTER TABLE `mentors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mentor_categories`
--
ALTER TABLE `mentor_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mentor_metas`
--
ALTER TABLE `mentor_metas`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mentor_services`
--
ALTER TABLE `mentor_services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mentor_single_categories`
--
ALTER TABLE `mentor_single_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mentor_single_educations`
--
ALTER TABLE `mentor_single_educations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mentor_single_experiences`
--
ALTER TABLE `mentor_single_experiences`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mentor_single_services`
--
ALTER TABLE `mentor_single_services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mentor_tags`
--
ALTER TABLE `mentor_tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mentor_weeks`
--
ALTER TABLE `mentor_weeks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `application_mentor_tags`
--
ALTER TABLE `application_mentor_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `application_types`
--
ALTER TABLE `application_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `category_tags`
--
ALTER TABLE `category_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `company_categories`
--
ALTER TABLE `company_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `company_single_categories`
--
ALTER TABLE `company_single_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mentors`
--
ALTER TABLE `mentors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `mentor_categories`
--
ALTER TABLE `mentor_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `mentor_metas`
--
ALTER TABLE `mentor_metas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mentor_services`
--
ALTER TABLE `mentor_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `mentor_single_categories`
--
ALTER TABLE `mentor_single_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT для таблицы `mentor_single_educations`
--
ALTER TABLE `mentor_single_educations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `mentor_single_experiences`
--
ALTER TABLE `mentor_single_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT для таблицы `mentor_single_services`
--
ALTER TABLE `mentor_single_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT для таблицы `mentor_tags`
--
ALTER TABLE `mentor_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `mentor_weeks`
--
ALTER TABLE `mentor_weeks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
