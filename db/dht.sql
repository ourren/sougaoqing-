/*
Navicat MySQL Data Transfer

Source Server         : www.bacdewu.com
Source Server Version : 50628
Source Host           : 127.0.0.1:3306
Source Database       : dht

Target Server Type    : MYSQL
Target Server Version : 50628
File Encoding         : 65001

Date: 2016-09-01 17:08:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for filelists
-- ----------------------------
DROP TABLE IF EXISTS `filelists`;
CREATE TABLE `filelists` (
  `hash_info` varchar(50) NOT NULL,
  `filenames` longtext,
  PRIMARY KEY (`hash_info`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for hash_info
-- ----------------------------
DROP TABLE IF EXISTS `hash_info`;
CREATE TABLE `hash_info` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `hash` varchar(40) NOT NULL,
  `name` varchar(254) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `filename` varchar(512) DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `filecounts` int(11) DEFAULT NULL,
  `filesize` bigint(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_hash` (`hash`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for movie_hash
-- ----------------------------
DROP TABLE IF EXISTS `movie_hash`;
CREATE TABLE `movie_hash` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `hash` varchar(40) NOT NULL,
  `name` varchar(254) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `source` varchar(50) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `filesize` bigint(20) DEFAULT NULL,
  `reqtimes` int(11) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_hash` (`hash`) USING BTREE,
  UNIQUE KEY `ix_name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6365292 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for statusreport
-- ----------------------------
DROP TABLE IF EXISTS `statusreport`;
CREATE TABLE `statusreport` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `new_hashs` int(11) DEFAULT NULL,
  `total_requests` int(11) DEFAULT NULL,
  `valid_requests` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10057087 DEFAULT CHARSET=utf8;
