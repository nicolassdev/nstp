/*
 Navicat Premium Data Transfer

 Source Server         : database
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : nstp_db

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 05/02/2026 16:32:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_student
-- ----------------------------
DROP TABLE IF EXISTS `tbl_student`;
CREATE TABLE `tbl_student`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `suffix_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `birthdate` date NULL DEFAULT NULL,
  `contact_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sex` tinyint(1) NOT NULL COMMENT '0 = Female; 1 = Male',
  `photo` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_created` datetime NULL DEFAULT NULL,
  `date_modified` datetime NULL DEFAULT NULL,
  `created_by` int NOT NULL COMMENT 'Account ID',
  `modified_by` int NULL DEFAULT NULL COMMENT 'Account ID',
  `special_status` tinyint NULL DEFAULT NULL COMMENT 'Special Status ( 0 = None; 1 = Senior Citizen; 2 = PWD; 3 = Others;)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_student
-- ----------------------------
INSERT INTO `tbl_student` VALUES (1, 'Ayalla', 'Ralph', NULL, NULL, 'ralph@gmail.com', 'Legazpi City', '2002-10-01', '09955310164', 1, NULL, NULL, NULL, 0, NULL, NULL);
INSERT INTO `tbl_student` VALUES (2, 'Lustado', 'Lorena', 'Lorica', NULL, 'lustado@gmail.com', 'Legazpi City', '2002-10-01', '946464646464', 0, NULL, NULL, NULL, 0, NULL, NULL);
INSERT INTO `tbl_student` VALUES (3, 'Falcon', 'James', NULL, NULL, 'falcon@gmail.com', 'Legazpi City', '2002-10-01', '946464646464', 1, NULL, NULL, NULL, 0, NULL, NULL);
INSERT INTO `tbl_student` VALUES (4, 'Taldo', 'Barbie', 'Lorica', NULL, 'barbie@gmail.com', 'Legazpi City', '2002-10-01', '946464646464', 0, NULL, NULL, NULL, 0, NULL, NULL);
INSERT INTO `tbl_student` VALUES (5, 'Baldo', 'Juan', 'Lorica', NULL, 'barbie@gmail.com', 'Legazpi City', '2002-10-01', '946464646464', 1, NULL, NULL, NULL, 0, NULL, NULL);
INSERT INTO `tbl_student` VALUES (6, 'Palbos', 'Jack', NULL, NULL, 'jack@gmail.com', 'Cruzada Legazpi City', '2003-02-05', '0992929922992', 1, NULL, NULL, NULL, 0, NULL, NULL);

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` blob NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `suffix_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `contact_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `sex` int NOT NULL COMMENT '0 = Female; 1 = Male',
  `birthdate` date NULL DEFAULT NULL,
  `address` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `photo` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_created` datetime NULL DEFAULT NULL,
  `date_modified` datetime NULL DEFAULT NULL,
  `created_by` int NOT NULL COMMENT 'Account ID',
  `modified_by` int NULL DEFAULT NULL COMMENT 'Account ID',
  `role` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 =  Superadmin\n | 1 = Registrar | 2 =DTR Downloader',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Flag for soft delete',
  `deleted_at` datetime NULL DEFAULT NULL,
  `last_login` datetime NULL DEFAULT NULL,
  `last_logout` datetime NULL DEFAULT NULL,
  `special_status` tinyint NULL DEFAULT NULL COMMENT 'Special Status ( 0 = None; 1 = Senior Citizen; 2 = PWD; 3 = Others;)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES (1, 'webmaster@pixel8', 0x313233, 'Daen', 'Anthony', NULL, NULL, NULL, '', 0, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, '2026-02-05 09:09:26', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
