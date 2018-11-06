/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : glonass

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2018-10-30 15:17:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_in` datetime DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `admin` tinyint(4) DEFAULT '1',
  `activ` int(1) DEFAULT '1' COMMENT 'Вход с СМС, 0 - да, 1 - нет',
  `generate` varchar(255) DEFAULT NULL,
  `isProvider` int(10) DEFAULT '0' COMMENT '0 - клиент, 1 - Порт-Транзит, 2 - Южные технологии',
  `role` int(1) DEFAULT '1' COMMENT '1- обычный пользователь, 2-ЮТ, 3-Мы',
  `confirm` int(1) DEFAULT '0',
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `occupation` int(2) NOT NULL DEFAULT '0',
  `status_id` int(11) unsigned NOT NULL DEFAULT '2' COMMENT 'vip status = 2',
  `balance` decimal(10,0) NOT NULL DEFAULT '0',
  `status_expiry` datetime DEFAULT '2016-08-01 00:00:00',
  `show_nat_services` int(1) unsigned NOT NULL DEFAULT '1',
  `working_with_nds` int(1) unsigned NOT NULL DEFAULT '0',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `place` varchar(255) DEFAULT NULL,
  `place_code` varchar(13) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `region_code` varchar(13) DEFAULT NULL,
  `rating` float NOT NULL DEFAULT '0',
  `has_docs` int(1) NOT NULL DEFAULT '0',
  `forum_blocked` int(1) NOT NULL DEFAULT '0',
  `forum_block_expiry` datetime DEFAULT NULL,
  `token_http` varchar(256) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_users_roles` (`role`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36824 DEFAULT CHARSET=cp1251;
SET FOREIGN_KEY_CHECKS=1;
