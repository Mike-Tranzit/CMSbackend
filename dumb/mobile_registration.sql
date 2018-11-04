/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : glonass

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2018-10-30 15:16:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mobile_registration
-- ----------------------------
DROP TABLE IF EXISTS `mobile_registration`;
CREATE TABLE `mobile_registration` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `last_sms_date` datetime DEFAULT NULL,
  `activation_code` varchar(6) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1427 DEFAULT CHARSET=utf8;
SET FOREIGN_KEY_CHECKS=1;
