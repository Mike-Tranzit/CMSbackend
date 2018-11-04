/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : zernovoz

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2018-10-30 15:16:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tarif_id` int(3) DEFAULT NULL,
  `count_request` int(3) DEFAULT '0',
  `count_month` int(3) DEFAULT '0',
  `count_weeks` int(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=cp1251;
SET FOREIGN_KEY_CHECKS=1;
