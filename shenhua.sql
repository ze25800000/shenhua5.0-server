/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : shenhua

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-09-02 16:15:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for equipment
-- ----------------------------
DROP TABLE IF EXISTS `equipment`;
CREATE TABLE `equipment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `equ_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of equipment
-- ----------------------------
INSERT INTO `equipment` VALUES ('1', '102', '一号破碎站');
INSERT INTO `equipment` VALUES ('2', '501', '二号破碎站');

-- ----------------------------
-- Table structure for oil_analysis
-- ----------------------------
DROP TABLE IF EXISTS `oil_analysis`;
CREATE TABLE `oil_analysis` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `oil_id` int(10) NOT NULL DEFAULT '0' COMMENT '油液编号',
  `equ_no` tinyint(10) NOT NULL DEFAULT '0' COMMENT '设备名称编号',
  `equ_oil_no` tinyint(10) NOT NULL DEFAULT '0' COMMENT '润滑点编号',
  `oil_name` varchar(50) DEFAULT '' COMMENT '油品名称',
  `sampling_time` varchar(50) DEFAULT '' COMMENT '采样日期',
  `working` int(10) DEFAULT '0' COMMENT '设备运行',
  `part` varchar(50) DEFAULT '' COMMENT '采样部位',
  `oil_used` int(10) DEFAULT '0' COMMENT '油品使用',
  `Fe` float(10,2) DEFAULT NULL,
  `Cu` float(10,2) DEFAULT NULL,
  `Pb` float(10,2) DEFAULT NULL,
  `Al` float(10,2) DEFAULT NULL,
  `Cr` float(10,2) DEFAULT NULL,
  `Si` float(10,2) DEFAULT NULL,
  `Na` float(10,2) DEFAULT NULL,
  `Mo` float(10,2) DEFAULT NULL,
  `viscosity` float(10,1) DEFAULT NULL COMMENT '粘度',
  `fuel_dilution` float(10,1) DEFAULT NULL COMMENT '燃油稀释',
  `ph` float(10,2) DEFAULT NULL COMMENT '酸值',
  `h2o` float(10,2) DEFAULT NULL COMMENT '水',
  `pq` tinyint(2) DEFAULT NULL COMMENT 'PQ',
  `contaminate` float(10,2) DEFAULT NULL COMMENT '污染度',
  `status` varchar(50) DEFAULT '良' COMMENT '状态',
  `advise` varchar(20) DEFAULT '继续使用' COMMENT '继续使用',
  `result` varchar(100) DEFAULT '' COMMENT '处理结果',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oil_analysis
-- ----------------------------

-- ----------------------------
-- Table structure for oil_standard
-- ----------------------------
DROP TABLE IF EXISTS `oil_standard`;
CREATE TABLE `oil_standard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equ_no` tinyint(10) NOT NULL DEFAULT '0' COMMENT '设备编号',
  `equ_oil_no` tinyint(10) NOT NULL DEFAULT '0' COMMENT '润滑点编号',
  `oil_name` varchar(100) NOT NULL DEFAULT '' COMMENT '润滑点全称',
  `oil_no` int(10) NOT NULL DEFAULT '0' COMMENT '物料编码',
  `quantity` tinyint(10) NOT NULL DEFAULT '0' COMMENT '用量',
  `unit` varchar(10) NOT NULL DEFAULT '' COMMENT '单位\n',
  `first_period` int(10) NOT NULL DEFAULT '0' COMMENT '首保周期',
  `period` int(10) NOT NULL DEFAULT '0' COMMENT '更换最长周期',
  `interval` int(10) NOT NULL DEFAULT '0' COMMENT '油脂采样间隔',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oil_standard_id_uindex` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='润滑标准样表';

-- ----------------------------
-- Records of oil_standard
-- ----------------------------
INSERT INTO `oil_standard` VALUES ('1', '100', '1', '一号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500');
INSERT INTO `oil_standard` VALUES ('2', '100', '2', '一号破碎站板式给料机右侧电动机后端轴承', '1071231', '100', 'KG', '500', '3500', '500');
INSERT INTO `oil_standard` VALUES ('3', '100', '3', '一号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500');
INSERT INTO `oil_standard` VALUES ('4', '100', '4', '一号破碎站板式给料机右侧电动后端轴承', '1071231', '100', 'KG', '500', '3500', '500');
INSERT INTO `oil_standard` VALUES ('5', '100', '5', '一号破碎站板式给料机左侧减速机', '1071231', '100', 'L', '500', '3500', '500');
INSERT INTO `oil_standard` VALUES ('6', '100', '6', '一号破碎站板式给料机右侧减速机', '1071231', '100', 'L', '500', '3500', '500');
INSERT INTO `oil_standard` VALUES ('7', '100', '7', '一号破碎站板式给料机低速联轴器', '1071231', '100', 'KG', '500', '3500', '500');
INSERT INTO `oil_standard` VALUES ('8', '100', '8', '一号破碎站板式给料机头轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500');
INSERT INTO `oil_standard` VALUES ('9', '100', '9', '一号破碎站板式给料机头轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500');
INSERT INTO `oil_standard` VALUES ('10', '100', '10', '一号破碎站板式给料机尾轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500');
INSERT INTO `oil_standard` VALUES ('11', '100', '11', '一号破碎站板式给料机尾轮右侧轴承', '1071231', '100', 'KG', '0', '3500', '500');
INSERT INTO `oil_standard` VALUES ('12', '100', '12', '一号破碎站板式给料机集中润滑泵', '1071231', '100', 'KG', '0', '3500', '500');
INSERT INTO `oil_standard` VALUES ('13', '100', '13', '一号破碎站破碎机电机', '1071231', '100', 'KG', '0', '3500', '500');
INSERT INTO `oil_standard` VALUES ('14', '100', '14', '一号破碎站破碎机偶合器', '1071231', '100', 'L', '500', '3500', '500');
INSERT INTO `oil_standard` VALUES ('15', '100', '15', '一号破碎站破碎机减速机', '1071231', '100', 'L', '500', '3500', '500');
INSERT INTO `oil_standard` VALUES ('16', '100', '16', '一号破碎站破碎机同步齿轮箱', '1071231', '100', 'L', '500', '3500', '500');
INSERT INTO `oil_standard` VALUES ('17', '100', '17', '一号破碎站破碎机机集中润滑泵', '1071231', '100', 'KG', '0', '3500', '500');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  `scope` tinyint(2) DEFAULT NULL COMMENT '权限 1：超级管理员 2：系统维护员 3：普通工作人员',
  `name` varchar(10) DEFAULT NULL,
  `phone` char(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_account_uindex` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '36', '杨泽', '15272828938');
INSERT INTO `user` VALUES ('3', 'yangze', 'e10adc3949ba59abbe56e057f20f883e', '18', 'asdf', '15148623483');
INSERT INTO `user` VALUES ('6', 'runhua1', '4297f44b13955235245b2497399d7a93', '9', '小芳', '15847928989');
INSERT INTO `user` VALUES ('7', 'runhua2', '123123', '18', '你好', '15847928989');
INSERT INTO `user` VALUES ('8', 'runhua3', '123123', '18', '列表', '15148625000');
