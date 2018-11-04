/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : zernovoz

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2018-10-30 15:14:23
*/

SET FOREIGN_KEY_CHECKS=0;

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
SET FOREIGN_KEY_CHECKS=1;
