-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.3.22-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных lira
CREATE DATABASE IF NOT EXISTS `lira` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `lira`;

-- Дамп структуры для таблица lira.ext_field_date
DROP TABLE IF EXISTS `ext_field_date`;
CREATE TABLE IF NOT EXISTS `ext_field_date` (
  `id_object` varchar(50) NOT NULL,
  `definition` varchar(50) NOT NULL,
  `field` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_object`,`definition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.ext_field_date: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `ext_field_date` DISABLE KEYS */;
/*!40000 ALTER TABLE `ext_field_date` ENABLE KEYS */;

-- Дамп структуры для таблица lira.ext_field_long_text
DROP TABLE IF EXISTS `ext_field_long_text`;
CREATE TABLE IF NOT EXISTS `ext_field_long_text` (
  `id_object` varchar(50) NOT NULL,
  `definition` varchar(50) NOT NULL,
  `field` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id_object`,`definition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.ext_field_long_text: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `ext_field_long_text` DISABLE KEYS */;
/*!40000 ALTER TABLE `ext_field_long_text` ENABLE KEYS */;

-- Дамп структуры для таблица lira.ext_field_number
DROP TABLE IF EXISTS `ext_field_number`;
CREATE TABLE IF NOT EXISTS `ext_field_number` (
  `id_object` varchar(50) NOT NULL,
  `definition` varchar(50) NOT NULL,
  `field` int(10) unsigned DEFAULT 0,
  PRIMARY KEY (`id_object`,`definition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.ext_field_number: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `ext_field_number` DISABLE KEYS */;
INSERT INTO `ext_field_number` (`id_object`, `definition`, `field`) VALUES
	('28d287a78cf8f0544ac0', 'order', 0),
	('9622a9247ffcac2b64b1', 'order', 10),
	('ce00669f92862ad6b38c', 'order', 5);
/*!40000 ALTER TABLE `ext_field_number` ENABLE KEYS */;

-- Дамп структуры для таблица lira.ext_field_object
DROP TABLE IF EXISTS `ext_field_object`;
CREATE TABLE IF NOT EXISTS `ext_field_object` (
  `id_object_parent` varchar(50) NOT NULL,
  `id_object_child` varchar(50) NOT NULL,
  `definition` varchar(50) DEFAULT NULL,
  `order` int(10) unsigned NOT NULL DEFAULT 0,
  `params` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_object_parent`,`id_object_child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.ext_field_object: ~32 rows (приблизительно)
/*!40000 ALTER TABLE `ext_field_object` DISABLE KEYS */;
INSERT INTO `ext_field_object` (`id_object_parent`, `id_object_child`, `definition`, `order`, `params`) VALUES
	('20736bce8b05ca22dea5', '252f0f43668f83843fb4', 'access', 0, '[]'),
	('252f0f43668f83843fb4', '05a08e0267f07e5a24c9', 'action', 0, '[]'),
	('252f0f43668f83843fb4', '10bc33a2fbfcc045add8', 'action', 0, '[]'),
	('252f0f43668f83843fb4', '17e4bdfd0650cf770724', 'action', 0, '[]'),
	('252f0f43668f83843fb4', '252f0f43668f83843fb4', 'access', 0, '[]'),
	('252f0f43668f83843fb4', '2bd6504c3c0fd86862f3', 'action', 0, '[]'),
	('252f0f43668f83843fb4', '411950ea311d76b1b743', 'action', 0, '[]'),
	('252f0f43668f83843fb4', '469aa8298cc65988366c', 'action', 0, '[]'),
	('252f0f43668f83843fb4', '55e091322c486b4766ce', 'action', 0, '[]'),
	('252f0f43668f83843fb4', '6b05644521e8c1b5bb5b', 'action', 0, '[]'),
	('252f0f43668f83843fb4', '7b7eb02cc4e83fd4e017', 'action', 0, '[]'),
	('252f0f43668f83843fb4', '8d420cbb9e3288e0e7cf', 'action', 0, '[]'),
	('252f0f43668f83843fb4', '9936513ff8773692b331', 'action', 0, '[]'),
	('252f0f43668f83843fb4', 'a90cdc62683e42b8ddc5', 'action', 0, '[]'),
	('252f0f43668f83843fb4', 'aff66bb4b72714a01c92', 'action', 0, '[]'),
	('252f0f43668f83843fb4', 'bb7a45fd2649de5c76c0', 'action', 0, '[]'),
	('252f0f43668f83843fb4', 'c7091d63ffc39311bfee', 'action', 0, '[]'),
	('252f0f43668f83843fb4', 'd59d0f372b8fa1143aa0', 'action', 0, '[]'),
	('252f0f43668f83843fb4', 'dbb983793af462d81fd8', 'action', 0, '[]'),
	('252f0f43668f83843fb4', 'de3b12649353c225c893', 'action', 0, '[]'),
	('252f0f43668f83843fb4', 'f48e64233d2e8c3272dc', 'action', 0, '[]'),
	('252f0f43668f83843fb4', 'fb4320537f4ea23be60b', 'action', 0, '[]'),
	('28d287a78cf8f0544ac0', '5e1cc7832dcbd43148d5', 'access', 0, '[]'),
	('4c63ec57845afa7dfeaf', '252f0f43668f83843fb4', 'access', 0, '[]'),
	('8bd5ca32f80ede40bf66', 'efec8802f9a4fe29f344', 'access', 0, '[]'),
	('9622a9247ffcac2b64b1', 'efec8802f9a4fe29f344', 'access', 0, '[]'),
	('ce00669f92862ad6b38c', '20736bce8b05ca22dea5', 'attachment', 1, '[]'),
	('ce00669f92862ad6b38c', '252f0f43668f83843fb4', 'access', 0, '[]'),
	('ce00669f92862ad6b38c', '4c63ec57845afa7dfeaf', 'attachment', 0, '[]'),
	('ce00669f92862ad6b38c', 'f1b0edc5bd2a0b648806', 'attachment', 2, '[]'),
	('edaaeece3a8dd89afdd4', '252f0f43668f83843fb4', 'access', 0, '[]'),
	('f1b0edc5bd2a0b648806', '252f0f43668f83843fb4', 'access', 0, '[]');
/*!40000 ALTER TABLE `ext_field_object` ENABLE KEYS */;

-- Дамп структуры для таблица lira.ext_field_short_text
DROP TABLE IF EXISTS `ext_field_short_text`;
CREATE TABLE IF NOT EXISTS `ext_field_short_text` (
  `id_object` varchar(50) NOT NULL,
  `definition` varchar(50) NOT NULL,
  `field` text DEFAULT NULL,
  PRIMARY KEY (`id_object`,`definition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.ext_field_short_text: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `ext_field_short_text` DISABLE KEYS */;
/*!40000 ALTER TABLE `ext_field_short_text` ENABLE KEYS */;

-- Дамп структуры для таблица lira.ext_field_string
DROP TABLE IF EXISTS `ext_field_string`;
CREATE TABLE IF NOT EXISTS `ext_field_string` (
  `id_object` char(50) NOT NULL,
  `definition` varchar(50) NOT NULL,
  `field` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_object`,`definition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.ext_field_string: ~38 rows (приблизительно)
/*!40000 ALTER TABLE `ext_field_string` DISABLE KEYS */;
INSERT INTO `ext_field_string` (`id_object`, `definition`, `field`) VALUES
	('05a08e0267f07e5a24c9', 'method', 'definition_edit'),
	('10bc33a2fbfcc045add8', 'method', 'object_select_field'),
	('17e4bdfd0650cf770724', 'method', 'definition_add'),
	('20736bce8b05ca22dea5', 'link', '/?com=definition&amp;task=list'),
	('252f0f43668f83843fb4', 'login', 'admin'),
	('252f0f43668f83843fb4', 'password', '3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79'),
	('28d287a78cf8f0544ac0', 'link', 'all'),
	('28d287a78cf8f0544ac0', 'module', 'mod_search'),
	('28d287a78cf8f0544ac0', 'position', 'search'),
	('2bd6504c3c0fd86862f3', 'method', 'definition_remove'),
	('411950ea311d76b1b743', 'method', 'object_upload'),
	('469aa8298cc65988366c', 'method', 'object_list'),
	('4c63ec57845afa7dfeaf', 'link', '/?com=object&amp;task=list'),
	('55e091322c486b4766ce', 'method', 'definition_list'),
	('6b05644521e8c1b5bb5b', 'method', 'definition_ajax'),
	('7b7eb02cc4e83fd4e017', 'method', 'object_edit'),
	('8bd5ca32f80ede40bf66', 'alias', 'main'),
	('8d420cbb9e3288e0e7cf', 'method', 'object_add'),
	('9622a9247ffcac2b64b1', 'link', 'all'),
	('9622a9247ffcac2b64b1', 'module', 'mod_auth'),
	('9622a9247ffcac2b64b1', 'position', 'left'),
	('9936513ff8773692b331', 'method', 'tag_ajax'),
	('a90cdc62683e42b8ddc5', 'method', 'object_remove_field'),
	('aff66bb4b72714a01c92', 'method', 'tag_edit'),
	('bb7a45fd2649de5c76c0', 'method', 'tag_remove'),
	('c7091d63ffc39311bfee', 'method', 'tag_list'),
	('ce00669f92862ad6b38c', 'ext_params', '{"show_block":"0","show_title":"0","template":"left_menu","id_menu":"ce00669f92862ad6b38c","css_id":"menu"}'),
	('ce00669f92862ad6b38c', 'link', 'all'),
	('ce00669f92862ad6b38c', 'module', 'mod_menu'),
	('ce00669f92862ad6b38c', 'position', 'left'),
	('d59d0f372b8fa1143aa0', 'method', 'object_ajax'),
	('dbb983793af462d81fd8', 'method', 'object_edit_field'),
	('de3b12649353c225c893', 'method', 'object_add_field'),
	('edaaeece3a8dd89afdd4', 'email', 'test@test.ts'),
	('edaaeece3a8dd89afdd4', 'link', 'lira.local'),
	('f1b0edc5bd2a0b648806', 'link', '/?com=tag&amp;task=list'),
	('f48e64233d2e8c3272dc', 'method', 'tag_add'),
	('fb4320537f4ea23be60b', 'method', 'object_remove');
/*!40000 ALTER TABLE `ext_field_string` ENABLE KEYS */;

-- Дамп структуры для таблица lira.ext_field_tag
DROP TABLE IF EXISTS `ext_field_tag`;
CREATE TABLE IF NOT EXISTS `ext_field_tag` (
  `id_object` varchar(50) NOT NULL,
  `definition` varchar(50) NOT NULL,
  `id_tag` varchar(50) NOT NULL,
  `order` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_object`,`definition`,`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.ext_field_tag: ~44 rows (приблизительно)
/*!40000 ALTER TABLE `ext_field_tag` DISABLE KEYS */;
INSERT INTO `ext_field_tag` (`id_object`, `definition`, `id_tag`, `order`) VALUES
	('05a08e0267f07e5a24c9', 'type', '78146489a690cf44dc7b', 0),
	('08d6de21890349aa24c9', 'tag', '02fe78a5ba8eac618a84', 0),
	('08d6de21890349aa24c9', 'tag', '04f47984d0251feb4024', 0),
	('08d6de21890349aa24c9', 'tag', '10c04a79b59ec4cd2ed2', 0),
	('08d6de21890349aa24c9', 'tag', '222f175702e93a060403', 0),
	('08d6de21890349aa24c9', 'tag', '4c6e856283f7afef2291', 0),
	('08d6de21890349aa24c9', 'tag', '78146489a690cf44dc7b', 0),
	('08d6de21890349aa24c9', 'tag', '86b5e76b8a6637060559', 0),
	('08d6de21890349aa24c9', 'tag', '8c7b781c3136fa1dd852', 0),
	('08d6de21890349aa24c9', 'tag', 'b258458e53d0805ed099', 0),
	('08d6de21890349aa24c9', 'tag', 'c870745049997772c959', 0),
	('08d6de21890349aa24c9', 'tag', 'e519ced5f53c7cee66a9', 0),
	('08d6de21890349aa24c9', 'type', '04f47984d0251feb4024', 0),
	('10bc33a2fbfcc045add8', 'type', '78146489a690cf44dc7b', 0),
	('17e4bdfd0650cf770724', 'type', '78146489a690cf44dc7b', 0),
	('20736bce8b05ca22dea5', 'type', '8c7b781c3136fa1dd852', 0),
	('252f0f43668f83843fb4', 'type', '86b5e76b8a6637060559', 0),
	('28d287a78cf8f0544ac0', 'type', '4c6e856283f7afef2291', 0),
	('2bd6504c3c0fd86862f3', 'type', '78146489a690cf44dc7b', 0),
	('411950ea311d76b1b743', 'type', '78146489a690cf44dc7b', 0),
	('469aa8298cc65988366c', 'type', '78146489a690cf44dc7b', 0),
	('4c63ec57845afa7dfeaf', 'type', '8c7b781c3136fa1dd852', 0),
	('55e091322c486b4766ce', 'type', '78146489a690cf44dc7b', 0),
	('5e1cc7832dcbd43148d5', 'type', '86b5e76b8a6637060559', 0),
	('6b05644521e8c1b5bb5b', 'type', '78146489a690cf44dc7b', 0),
	('7b7eb02cc4e83fd4e017', 'type', '78146489a690cf44dc7b', 0),
	('8bd5ca32f80ede40bf66', 'type', 'c870745049997772c959', 0),
	('8d420cbb9e3288e0e7cf', 'type', '78146489a690cf44dc7b', 0),
	('9622a9247ffcac2b64b1', 'type', '4c6e856283f7afef2291', 0),
	('9936513ff8773692b331', 'type', '78146489a690cf44dc7b', 0),
	('a90cdc62683e42b8ddc5', 'type', '78146489a690cf44dc7b', 0),
	('aff66bb4b72714a01c92', 'type', '78146489a690cf44dc7b', 0),
	('bb7a45fd2649de5c76c0', 'type', '78146489a690cf44dc7b', 0),
	('c7091d63ffc39311bfee', 'type', '78146489a690cf44dc7b', 0),
	('ce00669f92862ad6b38c', 'type', '4c6e856283f7afef2291', 0),
	('ce00669f92862ad6b38c', 'type', '8c7b781c3136fa1dd852', 1),
	('d59d0f372b8fa1143aa0', 'type', '78146489a690cf44dc7b', 0),
	('dbb983793af462d81fd8', 'type', '78146489a690cf44dc7b', 0),
	('de3b12649353c225c893', 'type', '78146489a690cf44dc7b', 0),
	('edaaeece3a8dd89afdd4', 'type', '04f47984d0251feb4024', 0),
	('efec8802f9a4fe29f344', 'type', '86b5e76b8a6637060559', 0),
	('f1b0edc5bd2a0b648806', 'type', '8c7b781c3136fa1dd852', 0),
	('f48e64233d2e8c3272dc', 'type', '78146489a690cf44dc7b', 0),
	('fb4320537f4ea23be60b', 'type', '78146489a690cf44dc7b', 0);
/*!40000 ALTER TABLE `ext_field_tag` ENABLE KEYS */;

-- Дамп структуры для таблица lira.main_definition
DROP TABLE IF EXISTS `main_definition`;
CREATE TABLE IF NOT EXISTS `main_definition` (
  `title` varchar(50) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.main_definition: ~29 rows (приблизительно)
/*!40000 ALTER TABLE `main_definition` DISABLE KEYS */;
INSERT INTO `main_definition` (`title`, `type`, `description`) VALUES
	('access', 'OBJECT', 'Доступ к объекту/access'),
	('action', 'OBJECT', 'Действие/action'),
	('alias', 'STRING', 'Псевдоним/alias'),
	('attachment', 'OBJECT', 'Вложение/attachment'),
	('author', 'OBJECT', 'Автор/author'),
	('content', 'TEXT', 'Контент/content'),
	('description', 'TEXT', 'Текст описания/description'),
	('email', 'STRING', 'Электронная почта/email'),
	('ext_params', 'STRING', 'Параметры/ext_params'),
	('image', 'OBJECT', 'Изображение объекта/image'),
	('large', 'STRING', 'Исходное изображение/large'),
	('link', 'STRING', 'Ссылка/link'),
	('login', 'STRING', 'Логин/login'),
	('longtext', 'LONGTEXT', 'Большой объём текста/longtext'),
	('medium', 'STRING', 'Размер изображения для публикации/medium'),
	('method', 'STRING', 'Метод (для разграничения прав на запуск функций объекта)'),
	('module', 'STRING', 'Модуль/module'),
	('number', 'NUMBER', 'Номер/number'),
	('order', 'NUMBER', 'Порядок/order'),
	('password', 'STRING', 'Пароль/password'),
	('path', 'STRING', 'Путь к ресурсу/path'),
	('photoalbum', 'OBJECT', 'Фотоальбом/photoalbum'),
	('position', 'STRING', 'Позиция/position'),
	('published', 'DATETIME', 'Дата публикации/published'),
	('query', 'STRING', 'Запрос/query'),
	('small', 'STRING', 'Превью изображения/small'),
	('status', 'TAG', 'Статус/status'),
	('tag', 'TAG', 'Тег/tag'),
	('type', 'TAG', 'Тип/type');
/*!40000 ALTER TABLE `main_definition` ENABLE KEYS */;

-- Дамп структуры для таблица lira.main_login
DROP TABLE IF EXISTS `main_login`;
CREATE TABLE IF NOT EXISTS `main_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(50) DEFAULT '0',
  `logged_in` datetime DEFAULT current_timestamp(),
  `ssid` varchar(50) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.main_login: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `main_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `main_login` ENABLE KEYS */;

-- Дамп структуры для таблица lira.main_object
DROP TABLE IF EXISTS `main_object`;
CREATE TABLE IF NOT EXISTS `main_object` (
  `id` varchar(50) NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.main_object: ~32 rows (приблизительно)
/*!40000 ALTER TABLE `main_object` DISABLE KEYS */;
INSERT INTO `main_object` (`id`, `title`, `created`) VALUES
	('05a08e0267f07e5a24c9', 'DEFINITION EDIT', '2019-12-10 10:54:48'),
	('08d6de21890349aa24c9', 'Типы объектов', '2020-01-30 12:34:27'),
	('10bc33a2fbfcc045add8', 'OBJECT SELECT FIELD', '2019-12-09 15:43:12'),
	('17e4bdfd0650cf770724', 'DEFINITION ADD', '2019-12-10 10:54:27'),
	('20736bce8b05ca22dea5', 'Определение', '2020-12-20 10:02:53'),
	('252f0f43668f83843fb4', 'Администратор', '2019-10-31 17:01:28'),
	('28d287a78cf8f0544ac0', 'Модуль строки поиска', '2020-12-19 21:48:07'),
	('2bd6504c3c0fd86862f3', 'DEFINITION REMOVE', '2019-12-10 10:55:11'),
	('411950ea311d76b1b743', 'OBJECT UPLOAD', '2019-12-09 15:42:37'),
	('469aa8298cc65988366c', 'OBJECT LIST', '2019-12-09 15:30:57'),
	('4c63ec57845afa7dfeaf', 'Объект', '2020-12-20 10:01:12'),
	('55e091322c486b4766ce', 'DEFINITION LIST', '2019-12-10 10:55:33'),
	('5e1cc7832dcbd43148d5', 'Зарегистрированные', '2019-12-11 11:07:39'),
	('6b05644521e8c1b5bb5b', 'DEFINITION AJAX', '2019-12-10 10:54:00'),
	('7b7eb02cc4e83fd4e017', 'OBJECT EDIT', '2019-12-09 15:30:02'),
	('8bd5ca32f80ede40bf66', 'Главная', '2019-12-09 16:12:19'),
	('8d420cbb9e3288e0e7cf', 'OBJECT ADD', '2019-12-09 15:29:19'),
	('9622a9247ffcac2b64b1', 'Модуль авторизации', '2020-12-19 21:36:33'),
	('9936513ff8773692b331', 'TAG AJAX', '2019-12-09 16:00:56'),
	('a90cdc62683e42b8ddc5', 'OBJECT REMOVE FIELD', '2019-12-09 15:43:50'),
	('aff66bb4b72714a01c92', 'TAG EDIT', '2019-12-09 16:01:41'),
	('bb7a45fd2649de5c76c0', 'TAG REMOVE', '2019-12-09 16:02:05'),
	('c7091d63ffc39311bfee', 'TAG LIST', '2019-12-09 16:08:44'),
	('ce00669f92862ad6b38c', 'Модуль меню администратора', '2020-12-20 09:59:31'),
	('d59d0f372b8fa1143aa0', 'OBJECT AJAX', '2019-12-09 15:09:42'),
	('dbb983793af462d81fd8', 'OBJECT EDIT FIELD', '2019-12-09 15:43:43'),
	('de3b12649353c225c893', 'OBJECT ADD FIELD', '2019-12-09 15:43:26'),
	('edaaeece3a8dd89afdd4', 'Система', '2020-12-20 11:44:31'),
	('efec8802f9a4fe29f344', 'Все', '2019-12-11 11:07:13'),
	('f1b0edc5bd2a0b648806', 'Тег', '2020-12-20 10:03:29'),
	('f48e64233d2e8c3272dc', 'TAG ADD', '2019-12-09 16:01:17'),
	('fb4320537f4ea23be60b', 'OBJECT REMOVE', '2019-12-09 15:30:28');
/*!40000 ALTER TABLE `main_object` ENABLE KEYS */;

-- Дамп структуры для таблица lira.main_tag
DROP TABLE IF EXISTS `main_tag`;
CREATE TABLE IF NOT EXISTS `main_tag` (
  `id` varchar(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы lira.main_tag: ~12 rows (приблизительно)
/*!40000 ALTER TABLE `main_tag` DISABLE KEYS */;
INSERT INTO `main_tag` (`id`, `title`) VALUES
	('02fe78a5ba8eac618a84', 'Запрос'),
	('04f47984d0251feb4024', 'Список'),
	('10c04a79b59ec4cd2ed2', 'Документ'),
	('222f175702e93a060403', 'Фрейм'),
	('4c6e856283f7afef2291', 'Модуль'),
	('738f26713fde89eec5b9', 'Фотогалерея'),
	('78146489a690cf44dc7b', 'Действие'),
	('86b5e76b8a6637060559', 'Пользователь'),
	('8c7b781c3136fa1dd852', 'Ссылка'),
	('b258458e53d0805ed099', 'Изображение'),
	('c870745049997772c959', 'Статья'),
	('e519ced5f53c7cee66a9', 'Фотоальбом');
/*!40000 ALTER TABLE `main_tag` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
