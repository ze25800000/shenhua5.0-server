/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : shenhua

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-09-05 17:57:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for equipment
-- ----------------------------
DROP TABLE IF EXISTS `equipment`;
CREATE TABLE `equipment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `equ_no` int(10) NOT NULL DEFAULT '0',
  `equ_name` varchar(50) NOT NULL DEFAULT '',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of equipment
-- ----------------------------
INSERT INTO `equipment` VALUES ('1', '100', '一号设备', '1504572680', '1504572680');
INSERT INTO `equipment` VALUES ('2', '200', '二号设备', '1504572697', '1504572697');

-- ----------------------------
-- Table structure for oil_analysis
-- ----------------------------
DROP TABLE IF EXISTS `oil_analysis`;
CREATE TABLE `oil_analysis` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `equ_no` int(11) NOT NULL DEFAULT '0' COMMENT '设备名称编号',
  `equ_oil_no` int(11) NOT NULL DEFAULT '0' COMMENT '润滑点编号',
  `oil_no` int(10) DEFAULT '0' COMMENT '物料编号',
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
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oil_analysis
-- ----------------------------
INSERT INTO `oil_analysis` VALUES ('40', '100', '2', null, null, '7/5/17 0:00', '0', '减速机', '442', '20.63', '0.38', '1.32', '0.49', '0.12', '4.92', '1.87', '0.00', '298.0', null, null, null, '15', null, '良', '继续使用', null, '1504581922', '1504582185');
INSERT INTO `oil_analysis` VALUES ('42', '100', '1', null, null, '7/5/17 0:00', '0', '减速机', '460', '34.07', '0.83', '2.03', '1.01', '0.73', '3.45', '5.65', '0.62', '192.0', null, null, null, '10', null, '良', '继续使用', null, '1504581922', '1504581922');
INSERT INTO `oil_analysis` VALUES ('44', '100', '1', null, null, '7/5/17 0:00', '0', '减速机', '452', '23.56', '1.37', '2.72', '1.80', '0.32', '33.33', '5.52', '1.04', '224.0', null, null, null, '40', null, '良', '继续使用', null, '1504581922', '1504581922');
INSERT INTO `oil_analysis` VALUES ('45', '100', '2', null, null, '7/5/17 0:00', '0', '减速机', '452', '26.04', '1.35', '2.29', '2.66', '0.46', '5.10', '6.26', '0.83', '246.0', null, null, null, '10', null, '良', '继续使用', null, '1504581922', '1504582661');
INSERT INTO `oil_analysis` VALUES ('47', '200', '1', null, null, '7/5/17 0:00', '0', '减速机', '452', '50.35', '0.91', '2.87', '0.84', '0.72', '4.67', '4.45', '0.75', '184.0', null, null, null, '45', null, '良', '继续使用', null, '1504581922', '1504581922');
INSERT INTO `oil_analysis` VALUES ('48', '200', '1', null, null, '7/5/17 0:00', '0', '减速机', '452', '37.83', '1.42', '3.57', '1.03', '0.66', '3.12', '6.63', '0.93', '200.0', null, null, null, '30', null, '良', '继续使用', null, '1504581922', '1504581971');
INSERT INTO `oil_analysis` VALUES ('50', '200', '2', null, null, '7/5/17 0:00', '0', '减速机', '452', '63.83', '1.53', '2.50', '1.12', '1.01', '3.98', '5.69', '1.02', '195.0', null, null, null, '70', null, '良', '继续使用', null, '1504581922', '1504581922');
INSERT INTO `oil_analysis` VALUES ('52', '200', '1', null, null, '7/5/17 0:00', '0', '减速机', '432', '37.30', '0.16', '0.00', '4.75', '0.92', '23.73', '1.42', '0.64', '454.0', null, null, null, '70', null, '良', '继续使用', null, '1504581922', '1504581922');
INSERT INTO `oil_analysis` VALUES ('53', '200', '1', null, null, '7/5/17 0:00', '0', '减速机', '452', '37.51', '0.98', '0.00', '4.99', '1.35', '10.13', '7.60', '2.81', '192.0', null, null, null, '10', null, '良', '继续使用', null, '1504581922', '1504581922');
INSERT INTO `oil_analysis` VALUES ('55', '200', '2', null, null, '7/5/17 0:00', '0', '减速机', '442', '13.26', '0.38', '1.32', '0.49', '0.12', '4.92', '1.87', '0.00', '298.0', null, null, null, '15', null, '良', '继续使用', null, '1504581922', '1504581922');
INSERT INTO `oil_analysis` VALUES ('56', '200', '3', null, null, '7/5/17 0:00', '0', '减速机', '442', '12.37', '0.30', '0.65', '0.84', '0.15', '4.61', '1.82', '0.00', '298.0', null, null, null, '20', null, '良', '继续使用', null, '1504581922', '1504581922');
INSERT INTO `oil_analysis` VALUES ('57', '200', '1', null, null, '7/5/17 0:00', '0', '减速机', '460', '34.07', '0.83', '2.03', '1.01', '0.73', '3.45', '5.65', '0.62', '192.0', null, null, null, '10', null, '良', '继续使用', null, '1504581922', '1504581922');

-- ----------------------------
-- Table structure for oil_detail
-- ----------------------------
DROP TABLE IF EXISTS `oil_detail`;
CREATE TABLE `oil_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oil_no` int(11) DEFAULT NULL COMMENT '物料编码',
  `oil_name` varchar(150) DEFAULT NULL COMMENT '润滑油名称',
  `detail` varchar(255) DEFAULT NULL COMMENT '物料描述',
  `unit` varchar(10) DEFAULT NULL COMMENT '单位',
  `price` float(10,2) DEFAULT NULL COMMENT '价格',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oil_detail_id_uindex` (`id`),
  UNIQUE KEY `oil_detail_oil_no_uindex` (`oil_no`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oil_detail
-- ----------------------------
INSERT INTO `oil_detail` VALUES ('24', '10889994', '通用锂基脂', '尚博 2#;1×17kg\\长城', 'KG', '13.50', '1504598260', '1504598304');
INSERT INTO `oil_detail` VALUES ('23', '11249924', '通用锂基脂', '尚博 1#;1×17kg\\长城', 'KG', '12.95', '1504598260', '1504598260');
INSERT INTO `oil_detail` VALUES ('5', '10209358', '抗磨液压油', 'DTE 25;VG46;1×208L\\美孚', 'L ', '20.56', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('7', '10209348', '抗磨液压油', 'DTE 10 超凡 15;VG15;1×208L\\美孚', 'L ', '21.34', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('9', '10209351', '抗磨液压油', 'DTE 10 超凡 32;VG32;1×208L\\美孚', 'L ', '21.70', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('10', '10209286', '超级齿轮油', '600 XP 220;VG220;1×208L\\美孚', 'L ', '17.01', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('11', '10209288', '超级齿轮油', '600 XP 320;VG320;1×208L\\美孚', 'L ', '18.61', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('12', '10209289', '超级齿轮油', '600 XP 460;VG460;1×208L\\美孚', 'L ', '18.77', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('13', '11102440', '液力传动油', '6#;1×170kg;200L\\昆仑', 'KG', '12.60', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('14', '10209398', '传动油', '424;1×208L\\美孚', 'L ', '24.30', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('22', '11249923', '通用锂基脂', '尚博 0#;1×17kg\\长城', 'KG', '12.95', '1504598260', '1504598260');
INSERT INTO `oil_detail` VALUES ('21', '10061964', '极压锂基润滑脂', '尚博 3#;1×17kg\\长城', 'KG', '13.98', '1504598260', '1504598260');
INSERT INTO `oil_detail` VALUES ('17', '10209313', '合成齿轮油', 'SHC 626;VG68;1×208L\\美孚', 'L ', '98.03', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('18', '10209315', '合成齿轮油', 'SHC 629;VG150;1×208L\\美孚', 'L ', '98.89', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('19', '11249919', '极压锂基润滑脂', '尚博 0#;1×17kg\\长城', 'KG', '14.03', '1504595393', '1504598260');
INSERT INTO `oil_detail` VALUES ('27', '10705085', '二硫化钼锂基润滑脂', '尚博 2#;1×17KG\\长城', 'KG', '15.11', '1504598260', '1504598260');
INSERT INTO `oil_detail` VALUES ('28', '11249914', '高温高速润滑脂', 'HTHS 2#;1×17kg\\长城', 'KG', '34.53', '1504598260', '1504598260');
INSERT INTO `oil_detail` VALUES ('29', '10209438', '复合锂基润滑脂', '力富 SHC 100;NLGI 2;1×16kg\\美孚', 'KG', '121.50', '1504598260', '1504598260');

-- ----------------------------
-- Table structure for oil_standard
-- ----------------------------
DROP TABLE IF EXISTS `oil_standard`;
CREATE TABLE `oil_standard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equ_no` int(11) NOT NULL DEFAULT '0' COMMENT '设备编号',
  `equ_name` varchar(255) DEFAULT '' COMMENT '设备名称',
  `equ_oil_no` int(11) NOT NULL DEFAULT '0' COMMENT '润滑点编号',
  `oil_name` varchar(100) NOT NULL DEFAULT '' COMMENT '润滑点全称',
  `oil_no` int(10) NOT NULL DEFAULT '0' COMMENT '物料编码',
  `quantity` tinyint(10) NOT NULL DEFAULT '0' COMMENT '用量',
  `unit` varchar(10) NOT NULL DEFAULT '' COMMENT '单位\n',
  `first_period` int(10) NOT NULL DEFAULT '0' COMMENT '首保周期',
  `period` int(10) NOT NULL DEFAULT '0' COMMENT '更换最长周期',
  `interval` int(10) NOT NULL DEFAULT '0' COMMENT '油脂采样间隔',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oil_standard_id_uindex` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='润滑标准样表';

-- ----------------------------
-- Records of oil_standard
-- ----------------------------
INSERT INTO `oil_standard` VALUES ('1', '100', '', '1', '一号破碎站板式给料机左侧电动机前端轴承', '120', '100', 'KG', '500', '3500', '500', '1504572705', '1504579948');
INSERT INTO `oil_standard` VALUES ('2', '100', '', '2', '一号破碎站板式给料机右侧电动机后端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('4', '100', '', '3', '一号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('5', '100', '', '4', '一号破碎站板式给料机右侧电动后端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('6', '100', '', '5', '一号破碎站板式给料机左侧减速机', '1071231', '100', 'L', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('7', '100', '', '6', '一号破碎站板式给料机右侧减速机', '1071231', '127', 'L', '500', '3500', '500', '1504572705', '1504579956');
INSERT INTO `oil_standard` VALUES ('8', '100', '', '7', '一号破碎站板式给料机低速联轴器', '1071231', '100', 'KG', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('9', '100', '', '8', '一号破碎站板式给料机头轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('10', '100', '', '9', '一号破碎站板式给料机头轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('11', '100', '', '10', '一号破碎站板式给料机尾轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('12', '100', '', '11', '一号破碎站板式给料机尾轮右侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('13', '100', '', '12', '一号破碎站板式给料机集中润滑泵', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('14', '100', '', '13', '一号破碎站破碎机电机', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('16', '100', '', '14', '一号破碎站破碎机偶合器', '1071231', '100', 'L', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('17', '100', '', '15', '一号破碎站破碎机减速机', '1071231', '100', 'L', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('19', '100', '', '16', '一号破碎站破碎机同步齿轮箱', '1071231', '100', 'L', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('21', '200', '', '1', '二号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('22', '200', '', '2', '二号破碎站板式给料机右侧电动机后端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('23', '200', '', '3', '二号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('24', '200', '', '4', '二号破碎站板式给料机右侧电动后端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('25', '200', '', '5', '二号破碎站板式给料机左侧减速机', '1071231', '100', 'L', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('26', '200', '', '6', '二号破碎站板式给料机右侧减速机', '1071231', '100', 'L', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('27', '200', '', '7', '二号破碎站板式给料机低速联轴器', '1071231', '100', 'KG', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('28', '200', '', '8', '二号破碎站板式给料机头轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('29', '200', '', '9', '二号破碎站板式给料机头轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('30', '200', '', '10', '二号破碎站板式给料机尾轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('31', '200', '', '11', '二号破碎站板式给料机尾轮右侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('32', '200', '', '12', '二号破碎站板式给料机集中润滑泵', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('33', '200', '', '13', '二号破碎站破碎机电机', '1071231', '100', 'KG', '0', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('34', '200', '', '14', '二号破碎站破碎机偶合器', '1071231', '100', 'L', '500', '3500', '500', '1504572705', '1504573517');
INSERT INTO `oil_standard` VALUES ('35', '200', '', '15', '二号破碎站破碎机减速机', '1071231', '100', 'L', '500', '3500', '500', '1504573517', '1504573517');
INSERT INTO `oil_standard` VALUES ('36', '200', '', '16', '二号破碎站破碎机同步齿轮箱', '1071231', '100', 'L', '500', '3500', '500', '1504573517', '1504573517');
INSERT INTO `oil_standard` VALUES ('37', '200', '', '17', '二号破碎站破碎机机集中润滑泵', '1071231', '100', 'KG', '0', '3500', '500', '1504573517', '1504573517');

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
INSERT INTO `user` VALUES ('7', 'runhua2', '123123', '18', '你好', '15847928989');
INSERT INTO `user` VALUES ('8', 'runhua3', '123123', '18', '列表', '15148625000');
