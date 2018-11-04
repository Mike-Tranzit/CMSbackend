/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : zernovoz

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2018-10-30 15:14:36
*/

SET FOREIGN_KEY_CHECKS=0;

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
SET FOREIGN_KEY_CHECKS=1;
