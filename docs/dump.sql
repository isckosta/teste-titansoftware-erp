/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 100425
 Source Host           : localhost:3306
 Source Schema         : crud

 Target Server Type    : MySQL
 Target Server Version : 100425
 File Encoding         : 65001

 Date: 07/10/2022 17:43:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for price
-- ----------------------------
DROP TABLE IF EXISTS `price`;
CREATE TABLE `price`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of price
-- ----------------------------
INSERT INTO `price` VALUES (47, 2800.00);
INSERT INTO `price` VALUES (48, 4200.00);
INSERT INTO `price` VALUES (49, 25.00);
INSERT INTO `price` VALUES (51, 250.00);

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `price_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `FK_product_price`(`price_id` ASC) USING BTREE,
  CONSTRAINT `FK_product_price` FOREIGN KEY (`price_id`) REFERENCES `price` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 84 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (79, 'Ar condicionado', 'Vermelho', 47);
INSERT INTO `products` VALUES (80, 'Notebook Dell i7 - 8GB RAM', 'Azul', 48);
INSERT INTO `products` VALUES (81, 'A4 - Resma', 'Amarelo', 49);
INSERT INTO `products` VALUES (83, 'Relógio Orient', 'Azul', 51);

SET FOREIGN_KEY_CHECKS = 1;
