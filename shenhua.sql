/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : shenhua

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-09-01 17:59:58
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
-- Table structure for lubricating_point
-- ----------------------------
DROP TABLE IF EXISTS `lubricating_point`;
CREATE TABLE `lubricating_point` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `lub_id` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `equ_id` int(10) NOT NULL DEFAULT '0',
  `lubr_name` varchar(50) DEFAULT '',
  `material_no` varchar(20) DEFAULT '',
  `quantity` varchar(20) DEFAULT '',
  `unit` varchar(10) DEFAULT '',
  `first_period` int(10) unsigned DEFAULT '0',
  `longest_period` int(10) unsigned DEFAULT '0',
  `sampling_period` int(10) unsigned DEFAULT '0',
  `last_lubricate_time` varchar(50) DEFAULT '',
  `status` tinyint(1) unsigned DEFAULT NULL,
  `user_id` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lubricating_point
-- ----------------------------
INSERT INTO `lubricating_point` VALUES ('1', '00001', '102', '一号破碎机板式给料机电动机1前端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1432278000', '1', '1000');
INSERT INTO `lubricating_point` VALUES ('2', '00002', '102', '一号破碎机板式给料机电动机1后端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1432278000', '1', '1000');
INSERT INTO `lubricating_point` VALUES ('3', '00003', '102', '一号破碎机板式给料机电动机2号后端轴承', '1071231', '100', 'KG', '500', '3500', '500', '1432278000', '1', '1000');

-- ----------------------------
-- Table structure for oil_analysis
-- ----------------------------
DROP TABLE IF EXISTS `oil_analysis`;
CREATE TABLE `oil_analysis` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `oil_id` int(10) NOT NULL DEFAULT '0' COMMENT '油液编号',
  `lub_id` int(10) NOT NULL DEFAULT '0' COMMENT '润滑点编号',
  `equ_id` int(10) NOT NULL DEFAULT '0' COMMENT '设备名称编号',
  `name` varchar(50) DEFAULT '' COMMENT '油品名称',
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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oil_analysis
-- ----------------------------
INSERT INTO `oil_analysis` VALUES ('1', '29389', '1', '102', '', '2017/7/5 星期三', '0', '减速机', '442', '8.31', '0.22', '0.64', '0.27', '0.08', '5.98', '0.78', '0.00', '302.0', null, null, null, '65', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('2', '29390', '2', '102', '', '2017/7/5 星期三', '0', '减速机', '442', '13.26', '0.38', '1.32', '0.49', '0.12', '4.92', '1.87', '0.00', '298.0', null, null, null, '15', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('3', '29391', '3', '102', '', '2017/7/5 星期三', '0', '减速机', '442', '12.37', '0.30', '0.65', '0.84', '0.15', '4.61', '1.82', '0.00', '298.0', null, null, null, '20', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('4', '29395', '1', '501', '', '2017/7/5 星期三', '0', '减速机', '460', '34.07', '0.83', '2.03', '1.01', '0.73', '3.45', '5.65', '0.62', '192.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('5', '29396', '2', '501', '', '2017/7/5 星期三', '0', '减速机', '460', '28.01', '1.47', '2.25', '1.02', '0.31', '5.74', '5.24', '0.76', '246.0', null, null, null, '30', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('6', '29397', '1', '502', '', '2017/7/5 星期三', '0', '减速机', '452', '23.56', '1.37', '2.72', '1.80', '0.32', '33.33', '5.52', '1.04', '224.0', null, null, null, '40', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('7', '29398', '2', '502', '', '2017/7/5 星期三', '0', '减速机', '452', '26.04', '1.35', '2.29', '1.66', '0.46', '5.10', '6.26', '0.83', '246.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('8', '29399', '1', '505', '', '2017/7/5 星期三', '0', '减速机', '452', '33.41', '0.77', '2.41', '0.84', '0.66', '2.75', '5.36', '0.85', '187.0', null, null, null, '45', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('9', '29400', '1', '506', '', '2017/7/5 星期三', '0', '减速机', '452', '50.35', '0.91', '2.87', '0.84', '0.72', '4.67', '4.45', '0.75', '184.0', null, null, null, '45', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('10', '29401', '1', '517', '', '2017/7/5 星期三', '0', '减速机', '452', '37.83', '1.42', '3.57', '1.03', '0.66', '3.12', '6.63', '0.93', '197.0', null, null, null, '30', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('11', '29402', '1', '518', '', '2017/7/5 星期三', '0', '减速机', '464', '33.47', '0.78', '2.17', '1.14', '0.60', '3.53', '5.17', '0.54', '179.0', null, null, null, '35', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('12', '29403', '2', '518', '', '2017/7/5 星期三', '0', '减速机', '452', '63.83', '1.53', '2.50', '1.12', '1.01', '3.98', '5.69', '1.02', '195.0', null, null, null, '70', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('13', '29404', '1', '519', '', '2017/7/5 星期三', '0', '减速机', '464', '25.14', '1.54', '2.73', '1.06', '0.38', '2.76', '5.54', '1.12', '223.5', null, null, null, '70', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('14', '29405', '1', '101', '', '2017/7/5 星期三', '0', '减速机', '432', '37.30', '0.16', '0.00', '4.75', '0.92', '23.73', '1.42', '0.64', '454.0', null, null, null, '70', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('15', '29406', '1', '501', '', '2017/7/5 星期三', '0', '减速机', '452', '37.51', '0.98', '0.00', '4.99', '1.35', '10.13', '7.60', '2.81', '192.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('16', '29738', '1', '102', '', '2017/7/5 星期三', '0', '减速机', '442', '8.31', '0.22', '0.64', '0.27', '0.08', '5.98', '0.78', '0.00', '302.0', null, null, null, '65', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('17', '29739', '2', '102', '', '2017/7/5 星期三', '0', '减速机', '442', '13.26', '0.38', '1.32', '0.49', '0.12', '4.92', '1.87', '0.00', '298.0', null, null, null, '15', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('18', '29740', '3', '102', '', '2017/7/5 星期三', '0', '减速机', '442', '12.37', '0.30', '0.65', '0.84', '0.15', '4.61', '1.82', '0.00', '298.0', null, null, null, '20', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('19', '29744', '1', '501', '', '2017/7/5 星期三', '0', '减速机', '460', '34.07', '0.83', '2.03', '1.01', '0.73', '3.45', '5.65', '0.62', '192.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('20', '29745', '2', '501', '', '2017/7/5 星期三', '0', '减速机', '460', '28.01', '1.47', '2.25', '1.02', '0.31', '5.74', '5.24', '0.76', '246.0', null, null, null, '30', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('21', '29746', '1', '502', '', '2017/7/5 星期三', '0', '减速机', '452', '23.56', '1.37', '2.72', '1.80', '0.32', '33.33', '5.52', '1.04', '224.0', null, null, null, '40', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('22', '29747', '2', '502', '', '2017/7/5 星期三', '0', '减速机', '452', '26.04', '1.35', '2.29', '1.66', '0.46', '5.10', '6.26', '0.83', '246.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('23', '29748', '1', '505', '', '2017/7/5 星期三', '0', '减速机', '452', '33.41', '0.77', '2.41', '0.84', '0.66', '2.75', '5.36', '0.85', '187.0', null, null, null, '45', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('24', '29749', '1', '506', '', '2017/7/5 星期三', '0', '减速机', '452', '50.35', '0.91', '2.87', '0.84', '0.72', '4.67', '4.45', '0.75', '184.0', null, null, null, '45', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('25', '29750', '1', '517', '', '2017/7/5 星期三', '0', '减速机', '452', '37.83', '1.42', '3.57', '1.03', '0.66', '3.12', '6.63', '0.93', '197.0', null, null, null, '30', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('26', '29751', '1', '518', '', '2017/7/5 星期三', '0', '减速机', '464', '33.47', '0.78', '2.17', '1.14', '0.60', '3.53', '5.17', '0.54', '179.0', null, null, null, '35', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('27', '29752', '2', '518', '', '2017/7/5 星期三', '0', '减速机', '452', '63.83', '1.53', '2.50', '1.12', '1.01', '3.98', '5.69', '1.02', '195.0', null, null, null, '70', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('28', '29753', '1', '519', '', '2017/7/5 星期三', '0', '减速机', '464', '25.14', '1.54', '2.73', '1.06', '0.38', '2.76', '5.54', '1.12', '223.5', null, null, null, '70', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('29', '29754', '1', '101', '', '2017/7/5 星期三', '0', '减速机', '432', '37.30', '0.16', '0.00', '4.75', '0.92', '23.73', '1.42', '0.64', '454.0', null, null, null, '70', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('30', '29755', '1', '501', '', '2017/7/5 星期三', '0', '减速机', '452', '37.51', '0.98', '0.00', '4.99', '1.35', '10.13', '7.60', '2.81', '192.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('31', '29756', '1', '601', '', '2017/7/5 星期三', '0', '减速机', '1600', '49.56', '0.49', '0.00', '0.73', '0.50', '0.75', '1.28', '0.00', '207.0', null, null, null, '5', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('32', '29757', '1', '602', '', '2017/7/5 星期三', '0', '减速机', '1750', '4.86', '0.33', '0.00', '0.12', '0.00', '0.00', '0.46', '0.00', '217.0', null, null, null, '5', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('33', '29758', '2', '602', '', '2017/7/5 星期三', '0', '减速机', '1750', '6.33', '0.41', '0.00', '0.49', '0.10', '0.22', '0.74', '0.00', '217.0', null, null, null, '5', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('34', '29759', '3', '602', '', '2017/7/5 星期三', '0', '减速机', '1750', '8.16', '0.14', '0.00', '0.06', '0.03', '1.63', '0.50', '0.00', '214.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('35', '29763', '1', '504', '', '2017/7/5 星期三', '0', '减速机', '600', '29.49', '0.23', '0.06', '0.32', '0.15', '2.50', '1.40', '0.00', '207.0', null, null, null, '55', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('36', '29764', '1', '633', '', '2017/7/5 星期三', '0', '减速机', '600', '1.51', '0.01', '0.64', '0.00', '0.00', '0.00', '0.08', '0.00', '207.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('37', '29765', '1', '607', '', '2017/7/5 星期三', '0', '减速机', '7014', '14.76', '0.04', '0.52', '0.41', '0.00', '2.25', '0.18', '0.00', '206.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('38', '29766', '2', '607', '', '2017/7/5 星期三', '0', '减速机', '7014', '22.20', '0.02', '0.19', '0.59', '0.16', '1.63', '0.35', '0.00', '206.0', null, null, null, '15', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('39', '29767', '1', '608', '', '2017/7/5 星期三', '0', '减速机', '6976', '2.87', '0.04', '1.45', '0.55', '0.10', '1.94', '0.17', '0.00', '208.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('40', '29768', '2', '608', '', '2017/7/5 星期三', '0', '减速机', '4099', '6.15', '0.05', '0.18', '0.45', '0.19', '0.29', '0.33', '0.00', '207.0', null, null, null, '15', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('41', '29769', '1', '609', '', '2017/7/5 星期三', '0', '减速机', '6094', '1.44', '0.00', '0.00', '0.00', '0.00', '0.38', '0.06', '0.00', '209.0', null, null, null, '15', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('42', '29770', '2', '609', '', '2017/7/5 星期三', '0', '减速机', '6094', '6.57', '0.00', '0.31', '0.38', '0.14', '1.01', '0.11', '0.00', '207.0', null, null, null, '55', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('43', '29771', '1', '615', '', '2017/7/5 星期三', '0', '减速机', '1500', '1.71', '0.07', '0.37', '0.34', '0.00', '0.74', '0.14', '0.00', '429.0', null, null, null, '15', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('44', '29772', '1', '616', '', '2017/7/5 星期三', '0', '减速机', '1500', '1.18', '0.09', '0.00', '0.11', '0.00', '0.01', '0.00', '0.00', '427.0', null, null, null, '15', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('45', '29773', '1', '632', '', '2017/7/5 星期三', '0', '减速机', '1500', '2.58', '0.00', '0.59', '0.16', '0.00', '0.32', '0.05', '0.00', '203.9', null, null, null, '15', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('46', '29774', '2', '801', '', '2017/7/5 星期三', '0', '减速机', '320', '1.31', '0.02', '0.00', '0.00', '0.00', '0.79', '0.00', '0.00', '206.0', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('47', '29776', '1', '802', '', '2017/7/5 星期三', '0', '减速机', '3054', '7.45', '0.14', '0.00', '0.05', '0.06', '0.61', '0.67', '0.00', '209.0', null, null, null, '20', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('48', '29777', '1', '807', '', '2017/7/5 星期三', '0', '减速机', '3344', '8.89', '0.17', '0.54', '0.31', '0.15', '0.36', '0.77', '0.13', '209.0', null, null, null, '20', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('49', '29778', '1', '812', '', '2017/7/5 星期三', '0', '减速机', '3867', '14.95', '0.04', '0.06', '0.21', '0.14', '1.97', '0.43', '0.00', '207.0', null, null, null, '20', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('50', '29779', '1', '811', '', '2017/7/5 星期三', '0', '减速机', '3858', '8.70', '0.03', '0.00', '0.00', '0.00', '1.08', '0.31', '0.00', '208.0', null, null, null, '15', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('51', '29780', '1', '831', '', '2017/7/5 星期三', '0', '减速机', '3435', '16.62', '0.02', '0.01', '0.53', '0.20', '1.46', '0.49', '0.00', '207.7', null, null, null, '10', null, '良', '继续使用', '');
INSERT INTO `oil_analysis` VALUES ('52', '29781', '1', '832', '', '2017/7/5 星期三', '0', '减速机', '3676', '7.65', '0.40', '1.64', '0.21', '0.29', '1.94', '0.42', '0.25', '207.7', null, null, null, '15', null, '良', '继续使用', '');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL COMMENT '员工编号',
  `account` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  `scope` varchar(5) DEFAULT NULL COMMENT '权限 1：超级管理员 2：系统维护员 3：普通工作人员',
  `name` varchar(10) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `identity` varchar(18) DEFAULT NULL COMMENT '身份证',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_account_uindex` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '1000', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '36', '杨泽', 'ze258100000@sina.com', '15250219880905095X');
INSERT INTO `user` VALUES ('3', null, 'yangze', 'e10adc3949ba59abbe56e057f20f883e', '18', 'asdf', 'ze258100000@sina.com', null);
INSERT INTO `user` VALUES ('4', null, 'xiaoming', 'e10adc3949ba59abbe56e057f20f883e', '9', 'qewr', null, null);
