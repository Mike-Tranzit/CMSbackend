/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : glonass

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2018-10-30 15:17:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for subscriptions_active
-- ----------------------------
DROP TABLE IF EXISTS `subscriptions_active`;
CREATE TABLE `subscriptions_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `requests_left` int(11) NOT NULL,
  `permanent` int(11) NOT NULL DEFAULT '0',
  `plan_id` int(11) NOT NULL DEFAULT '0',
  `add_date` datetime DEFAULT NULL,
  `burnout_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2768 DEFAULT CHARSET=utf8;
SET FOREIGN_KEY_CHECKS=1;
