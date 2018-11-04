/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : zernovoz

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2018-10-30 15:14:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for invoices
-- ----------------------------
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datecreate` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(12,2) NOT NULL,
  `dateresult` datetime DEFAULT NULL,
  `userIdCreate` int(11) NOT NULL,
  `methodPay` int(11) NOT NULL DEFAULT '0',
  `orderId` varchar(11) NOT NULL,
  `amountIncome` decimal(12,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `userIdFK` (`userIdCreate`),
  CONSTRAINT `userIdFK` FOREIGN KEY (`userIdCreate`) REFERENCES `glonass`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=cp1251;

-- ----------------------------
-- Table structure for invoices_detail
-- ----------------------------
DROP TABLE IF EXISTS `invoices_detail`;
CREATE TABLE `invoices_detail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date_create` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_old` datetime DEFAULT NULL,
  `date_new` datetime DEFAULT NULL,
  `sub_active_old` int(4) DEFAULT NULL,
  `sub_active_new` int(4) DEFAULT NULL,
  `invId` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=cp1251;

-- ----------------------------
-- Table structure for tarif
-- ----------------------------
DROP TABLE IF EXISTS `tarif`;
CREATE TABLE `tarif` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `value` int(10) DEFAULT NULL,
  `count_month` int(5) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `value_text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=cp1251;

-- ----------------------------
-- Table structure for year_subscription
-- ----------------------------
DROP TABLE IF EXISTS `year_subscription`;
CREATE TABLE `year_subscription` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `count_request` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;
SET FOREIGN_KEY_CHECKS=1;
