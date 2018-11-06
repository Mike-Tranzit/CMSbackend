/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : glonass

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2018-10-30 15:17:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for user_docs
-- ----------------------------
DROP TABLE IF EXISTS `user_docs`;
CREATE TABLE `user_docs` (
  `user_id` int(10) unsigned zerofill NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `inn` varchar(255) NOT NULL,
  `place` varchar(255) DEFAULT NULL,
  `kpp` varchar(255) DEFAULT NULL,
  `ogrn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;
SET FOREIGN_KEY_CHECKS=1;
