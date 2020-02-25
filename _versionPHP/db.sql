/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 100406
 Source Host           : localhost:3306
 Source Schema         : p_agenda

 Target Server Type    : MySQL
 Target Server Version : 100406
 File Encoding         : 65001

 Date: 24/02/2020 22:29:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for events
-- ----------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_init` date NOT NULL,
  `time_init` time(0) NULL DEFAULT NULL,
  `date_finish` date NULL DEFAULT NULL,
  `time_finish` date NULL DEFAULT NULL,
  `allday` int(1) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user`(`user`) USING BTREE,
  CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `statuscode` int(1) NOT NULL DEFAULT 1,
  `birthdate` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'John', 'Doe', 'john@example.com', '$2a$07$F4EE2EA286K3GED084A29.RhSCLVF5r12OjKPjAbDbywSfu4kI60C', 1, '2019-11-24');
INSERT INTO `users` VALUES (2, 'Mary', 'Moe', 'mary@example.com', '$2a$07$96B6A.BB/7A2C..91H/.D.xzwWMzEYc9hdpxiiKN/1vRQiT0Ldeji', 1, '2019-11-24');
INSERT INTO `users` VALUES (3, 'Julie', 'Dooley', 'julie@example.com', '$2a$07$681F1ED46/72A0F73JF/0.4XJssSecvETDnhypDAse.YgJu/CMAGO', 1, '2019-11-24');

SET FOREIGN_KEY_CHECKS = 1;
