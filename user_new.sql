-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.20-log - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных user
CREATE DATABASE IF NOT EXISTS `user` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `user`;

-- Дамп структуры для таблица user.driver
CREATE TABLE IF NOT EXISTS `driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  `identification_document` tinyint(1) NOT NULL,
  `document_number` varchar(30) NOT NULL,
  `phone1` varchar(14) NOT NULL,
  `phone2` varchar(14) DEFAULT NULL,
  `confirm` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.driver: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `driver` DISABLE KEYS */;
/*!40000 ALTER TABLE `driver` ENABLE KEYS */;

-- Дамп структуры для таблица user.driver_user
CREATE TABLE IF NOT EXISTS `driver_user` (
  `driver_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `FK_driver_user_driver` (`driver_id`),
  KEY `FK_driver_user_user` (`user_id`),
  CONSTRAINT `FK_driver_user_driver` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`),
  CONSTRAINT `FK_driver_user_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.driver_user: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `driver_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `driver_user` ENABLE KEYS */;

-- Дамп структуры для таблица user.places
CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `lon` float NOT NULL,
  `lat` float NOT NULL,
  `address` text NOT NULL,
  `is_load` tinyint(4) NOT NULL,
  `is_unload` tinyint(4) NOT NULL,
  `kladr` varchar(13) NOT NULL,
  `speed_load` int(11) NOT NULL,
  `weight_distance` int(11) NOT NULL,
  `weight_length` int(11) NOT NULL,
  `weight_denomination` int(11) NOT NULL,
  `load_type` int(11) NOT NULL,
  `height_load` int(11) NOT NULL,
  `trawl_load` tinyint(4) NOT NULL DEFAULT '0',
  `working_day` varchar(255) NOT NULL,
  `working_hour` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.places: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `places` DISABLE KEYS */;
INSERT INTO `places` (`id`, `name`, `lon`, `lat`, `address`, `is_load`, `is_unload`, `kladr`, `speed_load`, `weight_distance`, `weight_length`, `weight_denomination`, `load_type`, `height_load`, `trawl_load`, `working_day`, `working_hour`) VALUES
	(1, 'Воронеж', 1, 1, 'Воронеж, ул. Красная 1а', 1, 0, '1', 5, 0, 18, 70, 1, 4500, 0, '{}', '{}'),
	(2, 'НЗТ', 2, 2, 'Новороссийск, ул. Портовая 36', 0, 1, '2', 300, 0, 18, 70, 0, 4500, 0, '{}', '{}');
/*!40000 ALTER TABLE `places` ENABLE KEYS */;

-- Дамп структуры для таблица user.requests_in_filter
CREATE TABLE IF NOT EXISTS `requests_in_filter` (
  `id` int(11) NOT NULL,
  `request_shipping_id` int(11) NOT NULL,
  `user_filter_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_requests_in_filter_request_shipping` (`request_shipping_id`),
  KEY `FK_requests_in_filter_user_filter` (`user_filter_id`),
  CONSTRAINT `FK_requests_in_filter_request_shipping` FOREIGN KEY (`request_shipping_id`) REFERENCES `request_shipping` (`id`),
  CONSTRAINT `FK_requests_in_filter_user_filter` FOREIGN KEY (`user_filter_id`) REFERENCES `user_filter` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.requests_in_filter: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `requests_in_filter` DISABLE KEYS */;
/*!40000 ALTER TABLE `requests_in_filter` ENABLE KEYS */;

-- Дамп структуры для таблица user.request_params
CREATE TABLE IF NOT EXISTS `request_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `param_id` int(11) NOT NULL,
  `value_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_req_id` (`request_id`),
  CONSTRAINT `FK_req_id` FOREIGN KEY (`request_id`) REFERENCES `request_shipping` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.request_params: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `request_params` DISABLE KEYS */;
/*!40000 ALTER TABLE `request_params` ENABLE KEYS */;

-- Дамп структуры для таблица user.request_shipping
CREATE TABLE IF NOT EXISTS `request_shipping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeLoad` int(11) NOT NULL,
  `placeUnload` int(11) NOT NULL,
  `distance` int(11) NOT NULL,
  `price` float NOT NULL,
  `dateStart` datetime NOT NULL,
  `dateEnd` datetime NOT NULL,
  `dateCreate` datetime NOT NULL,
  `dispatcherId` int(11) NOT NULL,
  `statusId` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `weightByDay` int(11) NOT NULL,
  `description` text NOT NULL,
  `shipper_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_request_shipping_places_1` (`placeLoad`),
  KEY `fk_request_shipping_places_2` (`placeUnload`),
  KEY `fk_request_shipping_shipper_1` (`shipper_id`),
  CONSTRAINT `fk_request_shipping_places_1` FOREIGN KEY (`placeLoad`) REFERENCES `places` (`id`),
  CONSTRAINT `fk_request_shipping_places_2` FOREIGN KEY (`placeUnload`) REFERENCES `places` (`id`),
  CONSTRAINT `fk_request_shipping_shipper_1` FOREIGN KEY (`shipper_id`) REFERENCES `shipper` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.request_shipping: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `request_shipping` DISABLE KEYS */;
INSERT INTO `request_shipping` (`id`, `placeLoad`, `placeUnload`, `distance`, `price`, `dateStart`, `dateEnd`, `dateCreate`, `dispatcherId`, `statusId`, `weight`, `weightByDay`, `description`, `shipper_id`) VALUES
	(5, 1, 2, 1200, 3.4, '2017-12-17 11:50:29', '2017-12-19 11:50:31', '2017-12-17 11:50:34', 1, 1, 10000, 50, 'Комментарий', 1);
/*!40000 ALTER TABLE `request_shipping` ENABLE KEYS */;

-- Дамп структуры для таблица user.request_shipping_day
CREATE TABLE IF NOT EXISTS `request_shipping_day` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_shipping_id` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `speed_load` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `price` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_request_shipping_day_request_shipping_1` (`request_shipping_id`),
  CONSTRAINT `fk_request_shipping_day_request_shipping_1` FOREIGN KEY (`request_shipping_id`) REFERENCES `request_shipping` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.request_shipping_day: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `request_shipping_day` DISABLE KEYS */;
INSERT INTO `request_shipping_day` (`id`, `request_shipping_id`, `date`, `speed_load`, `status`, `price`) VALUES
	(1, 5, '2017-12-18 00:00:00', 5, 1, 4),
	(2, 5, '2017-12-19 00:00:00', 5, 1, 4);
/*!40000 ALTER TABLE `request_shipping_day` ENABLE KEYS */;

-- Дамп структуры для таблица user.shipper
CREATE TABLE IF NOT EXISTS `shipper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_custom` varchar(255) NOT NULL,
  `name_official` varchar(255) NOT NULL,
  `inn` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.shipper: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `shipper` DISABLE KEYS */;
INSERT INTO `shipper` (`id`, `name_custom`, `name_official`, `inn`) VALUES
	(1, 'Поток', 'ООО "Поток"', '123456789');
/*!40000 ALTER TABLE `shipper` ENABLE KEYS */;

-- Дамп структуры для таблица user.token
CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expired_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `idx-token-user_id` (`user_id`),
  CONSTRAINT `fk-token-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы user.token: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
/*!40000 ALTER TABLE `token` ENABLE KEYS */;

-- Дамп структуры для таблица user.trailer
CREATE TABLE IF NOT EXISTS `trailer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plate` varchar(10) NOT NULL,
  `truck_id` int(11) NOT NULL,
  `confirm` tinyint(1) DEFAULT '0',
  `tonnage` int(10) NOT NULL,
  `vehicle_certificate` varchar(50) NOT NULL,
  `identification_document` tinyint(1) NOT NULL,
  `document_number` varchar(50) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_trailer_truck` (`truck_id`),
  CONSTRAINT `FK_trailer_truck` FOREIGN KEY (`truck_id`) REFERENCES `truck` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.trailer: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `trailer` DISABLE KEYS */;
/*!40000 ALTER TABLE `trailer` ENABLE KEYS */;

-- Дамп структуры для таблица user.trailer_user
CREATE TABLE IF NOT EXISTS `trailer_user` (
  `trailer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `FK_trailer_user_trailer` (`trailer_id`),
  KEY `FK_trailer_user_user` (`user_id`),
  CONSTRAINT `FK_trailer_user_trailer` FOREIGN KEY (`trailer_id`) REFERENCES `trailer` (`id`),
  CONSTRAINT `FK_trailer_user_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.trailer_user: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `trailer_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `trailer_user` ENABLE KEYS */;

-- Дамп структуры для таблица user.truck
CREATE TABLE IF NOT EXISTS `truck` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plate` varchar(10) NOT NULL,
  `confirm` tinyint(1) DEFAULT '0',
  `brand` varchar(50) NOT NULL,
  `tonnage` int(10) NOT NULL,
  `city` smallint(6) DEFAULT NULL,
  `track` smallint(6) DEFAULT NULL,
  `laden` smallint(6) DEFAULT NULL,
  `empty` smallint(6) DEFAULT NULL,
  `trailer_type` tinyint(1) NOT NULL,
  `vehicle_certificate` varchar(50) NOT NULL,
  `glonass` tinyint(1) NOT NULL DEFAULT '0',
  `identification_document` tinyint(1) NOT NULL,
  `document_number` varchar(50) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.truck: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `truck` DISABLE KEYS */;
/*!40000 ALTER TABLE `truck` ENABLE KEYS */;

-- Дамп структуры для таблица user.truck_user
CREATE TABLE IF NOT EXISTS `truck_user` (
  `truck_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `FK_user_truck_truck` (`truck_id`),
  KEY `FK_user_truck_user` (`user_id`),
  CONSTRAINT `FK_user_truck_truck` FOREIGN KEY (`truck_id`) REFERENCES `truck` (`id`),
  CONSTRAINT `FK_user_truck_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.truck_user: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `truck_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `truck_user` ENABLE KEYS */;

-- Дамп структуры для таблица user.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` smallint(6) NOT NULL DEFAULT '10',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы user.user: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `role`, `auth_key`, `password_hash`, `password_reset_token`, `created_at`, `updated_at`) VALUES
	(1, '+79183333333', 10, 'wJ8zbPAkHNA0oshih4LpRg9DF5kVyTit', '$2y$13$mvTKJgGVpXnL9rvKDQHJ.Oo2jOoZJre6mXYziiYYpHpsNePvvk0cW', NULL, 1512483270, 1512483270),
	(2, '+79283333333', 10, 'wJ8zbPAkHNA0oshih4LpRg9DF5kVyTit', '$2y$13$mvTKJgGVpXnL9rvKDQHJ.Oo2jOoZJre6mXYziiYYpHpsNePvvk0cW', NULL, 1512483270, 1512483270),
	(3, '+79083333333', 10, 'wJ8zbPAkHNA0oshih4LpRg9DF5kVyTit', '$2y$13$mvTKJgGVpXnL9rvKDQHJ.Oo2jOoZJre6mXYziiYYpHpsNePvvk0cW', NULL, 1512483270, 1512483270);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Дамп структуры для таблица user.user_filter
CREATE TABLE IF NOT EXISTS `user_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_user_filter_user` (`user_id`),
  CONSTRAINT `FK_user_filter_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы user.user_filter: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `user_filter` DISABLE KEYS */;
INSERT INTO `user_filter` (`id`, `user_id`, `date_update`, `status`) VALUES
	(1, 1, '2017-12-18 15:39:30', 1);
/*!40000 ALTER TABLE `user_filter` ENABLE KEYS */;

-- Дамп структуры для таблица user.user_filter_value
CREATE TABLE IF NOT EXISTS `user_filter_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_filter_id` int(11) NOT NULL,
  `param_id` int(11) NOT NULL,
  `param_value_min` int(11) NOT NULL,
  `param_value_max` int(11) NOT NULL,
  `param_value_fix` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_filter_value_user` (`user_id`),
  KEY `FK_user_filter_value_user_filter` (`user_filter_id`),
  CONSTRAINT `FK_user_filter_value_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_user_filter_value_user_filter` FOREIGN KEY (`user_filter_id`) REFERENCES `user_filter` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='SELECT COUNT(id) as c, user_filter_id from user_filter_value where ((param_id = 1 and param_value = 3) or (param_id = 2 and param_value = 4)) and (param_id = 2 and param_value = 4)  GROUP BY user_filter_id HAVING c = 1';

-- Дамп данных таблицы user.user_filter_value: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `user_filter_value` DISABLE KEYS */;
INSERT INTO `user_filter_value` (`id`, `user_id`, `user_filter_id`, `param_id`, `param_value_min`, `param_value_max`, `param_value_fix`) VALUES
	(1, 1, 1, 1, 0, 0, 50),
	(2, 1, 1, 2, 0, 120, 0),
	(3, 1, 1, 3, 0, 0, 1);
/*!40000 ALTER TABLE `user_filter_value` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
