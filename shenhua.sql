/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : shenhua

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-09-07 17:57:01
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of equipment
-- ----------------------------
INSERT INTO `equipment` VALUES ('3', '100', '一号破碎站', '1504776671', '1504776671');
INSERT INTO `equipment` VALUES ('4', '200', '二号破碎站', '1504776687', '1504776687');

-- ----------------------------
-- Table structure for equ_detail
-- ----------------------------
DROP TABLE IF EXISTS `equ_detail`;
CREATE TABLE `equ_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `equ_no` int(10) DEFAULT NULL,
  `equ_oil_no` int(10) DEFAULT NULL,
  `equ_key_no` int(20) DEFAULT NULL,
  `equ_name` varchar(100) DEFAULT NULL,
  `equ_oil_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of equ_detail
-- ----------------------------

-- ----------------------------
-- Table structure for info_warning
-- ----------------------------
DROP TABLE IF EXISTS `info_warning`;
CREATE TABLE `info_warning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equ_no` int(11) NOT NULL COMMENT '设备编号',
  `equ_oil_no` int(11) NOT NULL COMMENT '润滑点编号',
  `equ_key_no` int(10) DEFAULT NULL,
  `equ_name` varchar(100) DEFAULT NULL COMMENT '设备名称',
  `equ_oil_name` varchar(255) DEFAULT NULL COMMENT '润滑点名称',
  `del_warning_time` varchar(100) DEFAULT NULL,
  `is_first_period` tinyint(1) DEFAULT NULL COMMENT '是否在首保周期',
  `status` tinyint(1) DEFAULT NULL,
  `how_long` int(11) DEFAULT NULL COMMENT '距离上次润滑的运行时长',
  `warning_type` tinyint(1) DEFAULT NULL COMMENT '1:润滑 0:延期 ',
  `postpone` int(10) DEFAULT NULL COMMENT '延期时长',
  `postpone_reason` varchar(255) DEFAULT NULL COMMENT '延期原因',
  `member` varchar(20) DEFAULT NULL COMMENT '操作人员',
  `oil_no` int(11) DEFAULT NULL COMMENT '物料编号',
  `quantity` int(10) DEFAULT NULL COMMENT '用量',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=558 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of info_warning
-- ----------------------------
INSERT INTO `info_warning` VALUES ('544', '200', '1', null, '二号破碎站', '二号破碎站板式给料机左侧电动机前端轴承', '1488297600', '0', '3', '3600', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('545', '200', '2', null, '二号破碎站', '二号破碎站板式给料机左侧电动机前端轴承', '1488470400', '1', '3', '3600', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('546', '200', '3', null, '二号破碎站', '二号破碎站板式给料机左侧电动机前端轴承', '1488643200', '0', '3', '3600', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('547', '200', '4', null, '二号破碎站', '二号破碎站板式给料机左侧电动机前端轴承', '1488816000', '0', '3', '3600', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('548', '200', '5', null, '二号破碎站', '二号破碎站板式给料机左侧电动机前端轴承', '1488988800', '0', '2', '3240', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('549', '200', '6', null, '二号破碎站', '二号破碎站板式给料机左侧电动机前端轴承', '1489161600', '0', '2', '3240', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('550', '200', '7', null, '二号破碎站', '二号破碎站板式给料机低速联轴器', '1489334400', '0', '1', '3240', '0', '300', '设备维修', 'xxx', null, null, '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('551', '200', '8', null, '二号破碎站', '二号破碎站板式给料机头轮左侧轴承', '1489507200', '0', '1', '3240', '0', '300', '设备维修', 'xxx', null, null, '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('552', '200', '9', null, '二号破碎站', '二号破碎站板式给料机头轮左侧轴承', '1489680000', '0', '1', '3240', '0', '300', '设备维修', 'xxx', null, null, '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('553', '200', '10', null, '二号破碎站', '二号破碎站板式给料机尾轮左侧轴承', '1489852800', '0', '2', '3240', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('554', '200', '11', null, '二号破碎站', '二号破碎站板式给料机尾轮右侧轴承', '1490025600', '0', '2', '3240', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('555', '200', '12', null, '二号破碎站', '二号破碎站板式给料机集中润滑泵', '1490198400', '0', '2', '3240', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('556', '200', '13', null, '二号破碎站', '二号破碎站破碎机电机', '1490371200', '0', '2', '3240', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');
INSERT INTO `info_warning` VALUES ('557', '200', '14', null, '二号破碎站', '二号破碎站破碎机偶合器', '1490544000', '0', '2', '3240', '1', null, null, 'xxx', '1071231', '100', '1504771303', '1504771303');

-- ----------------------------
-- Table structure for oil_analysis
-- ----------------------------
DROP TABLE IF EXISTS `oil_analysis`;
CREATE TABLE `oil_analysis` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `equ_no` int(11) NOT NULL DEFAULT '0' COMMENT '设备名称编号',
  `equ_oil_no` int(11) NOT NULL DEFAULT '0' COMMENT '润滑点编号',
  `equ_key_no` int(10) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oil_analysis
-- ----------------------------
INSERT INTO `oil_analysis` VALUES ('58', '100', '1', '1001', null, null, '7/5/17 0:00', '0', '减速机', '442', '8.31', '0.22', '0.64', '0.27', '0.08', '5.98', '0.78', '0.00', '302.0', null, null, null, '65', null, '良', '继续使用', null, '1504777199', '1504777199');
INSERT INTO `oil_analysis` VALUES ('59', '100', '2', '1002', null, null, '7/5/17 0:00', '0', '减速机', '442', '13.26', '0.38', '1.32', '0.49', '0.12', '4.92', '1.87', '0.00', '298.0', null, null, null, '15', null, '良', '继续使用', null, '1504777199', '1504777199');
INSERT INTO `oil_analysis` VALUES ('60', '100', '3', '1003', null, null, '7/5/17 0:00', '0', '减速机', '442', '12.37', '0.30', '0.65', '0.84', '0.15', '4.61', '1.82', '0.00', '298.0', null, null, null, '20', null, '良', '继续使用', null, '1504777199', '1504777199');
INSERT INTO `oil_analysis` VALUES ('61', '200', '1', '2001', null, null, '7/5/17 0:00', '0', '减速机', '460', '34.07', '0.83', '2.03', '1.01', '0.73', '3.45', '5.65', '0.62', '192.0', null, null, null, '10', null, '良', '继续使用', null, '1504777199', '1504777199');
INSERT INTO `oil_analysis` VALUES ('62', '200', '2', '2002', null, null, '7/5/17 0:00', '0', '减速机', '460', '28.01', '1.47', '2.25', '1.02', '0.31', '5.74', '5.24', '0.76', '246.0', null, null, null, '30', null, '良', '继续使用', null, '1504777199', '1504777199');

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
  `equ_oil_no` int(11) NOT NULL DEFAULT '0' COMMENT '润滑点编号',
  `equ_key_no` int(10) DEFAULT NULL,
  `equ_name` varchar(255) DEFAULT '' COMMENT '设备名称',
  `equ_oil_name` varchar(100) NOT NULL DEFAULT '' COMMENT '润滑点全称',
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
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COMMENT='润滑标准样表';

-- ----------------------------
-- Records of oil_standard
-- ----------------------------
INSERT INTO `oil_standard` VALUES ('115', '100', '10', '10010', '一号破碎站', '一号破碎站板式给料机尾轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('116', '100', '11', '10011', '一号破碎站', '一号破碎站板式给料机尾轮右侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('117', '100', '12', '10012', '一号破碎站', '一号破碎站板式给料机集中润滑泵', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('113', '100', '8', '1008', '一号破碎站', '一号破碎站板式给料机头轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('110', '100', '5', '1005', '一号破碎站', '一号破碎站板式给料机左侧减速机', '1071231', '100', 'L', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('111', '100', '6', '1006', '一号破碎站', '一号破碎站板式给料机右侧减速机', '1071231', '100', 'L', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('112', '100', '7', '1007', '一号破碎站', '一号破碎站板式给料机低速联轴器', '1071231', '100', 'KG', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('106', '100', '1', '1001', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('107', '100', '2', '1002', '一号破碎站', '一号破碎站板式给料机右侧电动机后端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('108', '100', '3', '1003', '一号破碎站', '一号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('109', '100', '4', '1004', '一号破碎站', '一号破碎站板式给料机右侧电动后端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('114', '100', '9', '1009', '一号破碎站', '一号破碎站板式给料机头轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('118', '100', '13', '10013', '一号破碎站', '一号破碎站破碎机电机', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('119', '100', '14', '10014', '一号破碎站', '一号破碎站破碎机偶合器', '1071231', '100', 'L', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('120', '100', '15', '10015', '一号破碎站', '一号破碎站破碎机减速机', '1071231', '100', 'L', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('121', '100', '16', '10016', '一号破碎站', '一号破碎站破碎机同步齿轮箱', '1071231', '100', 'L', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('122', '100', '17', '10017', '一号破碎站', '一号破碎站破碎机机集中润滑泵', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('123', '200', '1', '2001', '二号破碎站', '二号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('124', '200', '2', '2002', '二号破碎站', '二号破碎站板式给料机右侧电动机后端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('125', '200', '3', '2003', '二号破碎站', '二号破碎站板式给料机左侧电动机前端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('126', '200', '4', '2004', '二号破碎站', '二号破碎站板式给料机右侧电动后端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('127', '200', '5', '2005', '二号破碎站', '二号破碎站板式给料机左侧减速机', '1071231', '100', 'L', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('128', '200', '6', '2006', '二号破碎站', '二号破碎站板式给料机右侧减速机', '1071231', '100', 'L', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('129', '200', '7', '2007', '二号破碎站', '二号破碎站板式给料机低速联轴器', '1071231', '100', 'KG', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('130', '200', '8', '2008', '二号破碎站', '二号破碎站板式给料机头轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('131', '200', '9', '2009', '二号破碎站', '二号破碎站板式给料机头轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('132', '200', '10', '20010', '二号破碎站', '二号破碎站板式给料机尾轮左侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('133', '200', '11', '20011', '二号破碎站', '二号破碎站板式给料机尾轮右侧轴承', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('134', '200', '12', '20012', '二号破碎站', '二号破碎站板式给料机集中润滑泵', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('135', '200', '13', '20013', '二号破碎站', '二号破碎站破碎机电机', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('136', '200', '14', '20014', '二号破碎站', '二号破碎站破碎机偶合器', '1071231', '100', 'L', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('137', '200', '15', '20015', '二号破碎站', '二号破碎站破碎机减速机', '1071231', '100', 'L', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('138', '200', '16', '20016', '二号破碎站', '二号破碎站破碎机同步齿轮箱', '1071231', '100', 'L', '500', '3500', '500', '1504777813', '1504777813');
INSERT INTO `oil_standard` VALUES ('139', '200', '17', '20017', '二号破碎站', '二号破碎站破碎机机集中润滑泵', '1071231', '100', 'KG', '0', '3500', '500', '1504777813', '1504777813');

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

-- ----------------------------
-- Table structure for work_hour
-- ----------------------------
DROP TABLE IF EXISTS `work_hour`;
CREATE TABLE `work_hour` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `equ_no` int(11) NOT NULL COMMENT '设备编号',
  `equ_oil_no` int(11) NOT NULL COMMENT '润滑点编号',
  `equ_key_no` int(10) DEFAULT NULL,
  `equ_oil_name` varchar(100) DEFAULT NULL COMMENT '润滑点名称',
  `working_hour` int(100) NOT NULL,
  `start_time` int(100) DEFAULT NULL,
  `create_time` int(100) DEFAULT NULL,
  `update_time` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3823 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of work_hour
-- ----------------------------
INSERT INTO `work_hour` VALUES ('3655', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3656', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3657', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3658', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3659', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3660', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3661', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3662', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3663', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3664', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3665', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3666', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3667', '200', '13', null, '二号破碎站破碎机电机', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3668', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1483804800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3669', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3670', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3671', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3672', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3673', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3674', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3675', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3676', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3677', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3678', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3679', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3680', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3681', '200', '13', null, '二号破碎站破碎机电机', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3682', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1486483200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3683', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3684', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3685', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3686', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3687', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3688', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3689', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3690', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3691', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3692', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3693', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3694', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3695', '200', '13', null, '二号破碎站破碎机电机', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3696', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1488902400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3697', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3698', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3699', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3700', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3701', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3702', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3703', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3704', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3705', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3706', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3707', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3708', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3709', '200', '13', null, '二号破碎站破碎机电机', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3710', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1491580800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3711', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3712', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3713', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3714', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3715', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3716', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3717', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3718', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3719', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3720', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3721', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3722', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3723', '200', '13', null, '二号破碎站破碎机电机', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3724', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1494172800', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3725', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3726', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3727', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3728', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3729', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3730', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3731', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3732', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3733', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3734', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3735', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3736', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3737', '200', '13', null, '二号破碎站破碎机电机', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3738', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1496851200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3739', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3740', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3741', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3742', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3743', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3744', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3745', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3746', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3747', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3748', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3749', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3750', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3751', '200', '13', null, '二号破碎站破碎机电机', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3752', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1499443200', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3753', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3754', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3755', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3756', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3757', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3758', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3759', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3760', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3761', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3762', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3763', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3764', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3765', '200', '13', null, '二号破碎站破碎机电机', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3766', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1502121600', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3767', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3768', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3769', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3770', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3771', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3772', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3773', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3774', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3775', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3776', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3777', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3778', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3779', '200', '13', null, '二号破碎站破碎机电机', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3780', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1504800000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3781', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3782', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3783', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3784', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3785', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3786', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3787', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3788', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3789', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3790', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3791', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3792', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3793', '200', '13', null, '二号破碎站破碎机电机', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3794', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1507392000', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3795', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3796', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3797', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3798', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3799', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3800', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3801', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3802', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3803', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3804', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3805', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3806', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3807', '200', '13', null, '二号破碎站破碎机电机', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3808', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1510070400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3809', '200', '1', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3810', '200', '2', null, '二号破碎站板式给料机右侧电动机后端轴承', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3811', '200', '3', null, '二号破碎站板式给料机左侧电动机前端轴承', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3812', '200', '4', null, '二号破碎站板式给料机右侧电动后端轴承', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3813', '200', '5', null, '二号破碎站板式给料机左侧减速机', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3814', '200', '6', null, '二号破碎站板式给料机右侧减速机', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3815', '200', '7', null, '二号破碎站板式给料机低速联轴器', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3816', '200', '8', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3817', '200', '9', null, '二号破碎站板式给料机头轮左侧轴承', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3818', '200', '10', null, '二号破碎站板式给料机尾轮左侧轴承', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3819', '200', '11', null, '二号破碎站板式给料机尾轮右侧轴承', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3820', '200', '12', null, '二号破碎站板式给料机集中润滑泵', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3821', '200', '13', null, '二号破碎站破碎机电机', '360', '1512662400', '1504771247', '1504771247');
INSERT INTO `work_hour` VALUES ('3822', '200', '14', null, '二号破碎站破碎机偶合器', '360', '1512662400', '1504771247', '1504771247');
