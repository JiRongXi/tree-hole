/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 80018
 Source Host           : localhost:3306
 Source Schema         : treehole

 Target Server Type    : MySQL
 Target Server Version : 80018
 File Encoding         : 65001

 Date: 20/09/2022 08:32:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment`  (
  `c_id` int(50) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `m_id` int(50) NOT NULL COMMENT '消息id',
  `u_id` int(11) NOT NULL COMMENT '评论者id(用户)',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '用户名',
  `face_url` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '头像',
  `c_content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '评论内容',
  `likes` int(11) NOT NULL DEFAULT 0 COMMENT '评论赞数',
  `audit_time` timestamp NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`c_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 58 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES (58, 90, 7, '小猪佩奇123', 'http://tmp/WuFTJeieTsZE4cff7eadb800a14a28fb99283e7209a9.jpeg', '123', 0, '2022-09-19 17:12:50');
INSERT INTO `comment` VALUES (22, 31, 7, '小猪佩奇123', 'http://tmp/WuFTJeieTsZE4cff7eadb800a14a28fb99283e7209a9.jpeg', '23132142', 0, '2021-12-11 13:38:14');
INSERT INTO `comment` VALUES (23, 31, 7, '小猪佩奇123', 'http://tmp/WuFTJeieTsZE4cff7eadb800a14a28fb99283e7209a9.jpeg', 'ad撒大傻大所大所大所大所多撒大所大所大所大撒所大所多大所大撒多所撒多大所大所大所所多撒奥', 0, '2021-12-11 14:17:13');
INSERT INTO `comment` VALUES (30, 54, 7, '小猪佩奇123', 'http://tmp/WuFTJeieTsZE4cff7eadb800a14a28fb99283e7209a9.jpeg', '666', 0, '2021-12-14 14:02:17');
INSERT INTO `comment` VALUES (42, 71, 47, 'hhahh', 'http://tmp/kjqdn6CxjURs71fd241e057fdd37fbb516bc433b4519.jpeg', '熬夜不睡觉复习', 1, '2021-12-15 16:32:18');

-- ----------------------------
-- Table structure for comment_report
-- ----------------------------
DROP TABLE IF EXISTS `comment_report`;
CREATE TABLE `comment_report`  (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论举报id',
  `c_id` int(11) NOT NULL,
  `u_id1` int(11) NOT NULL COMMENT '举报者的u_id',
  `u_id2` int(11) NOT NULL COMMENT '被举报者的u_id',
  `cr_content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '评论举报说明',
  `cr_time` timestamp NOT NULL COMMENT '举报时间',
  PRIMARY KEY (`cr_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of comment_report
-- ----------------------------
INSERT INTO `comment_report` VALUES (10, 42, 49, 47, '不良评论伤害身体', '2021-12-15 16:34:19');

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message`  (
  `m_id` int(15) NOT NULL AUTO_INCREMENT COMMENT '消息id',
  `u_id` int(11) NOT NULL COMMENT '用户id',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '用户名',
  `face_url` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '用户头像地址',
  `m_content` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '树洞消息内容',
  `likes` int(11) NOT NULL DEFAULT 0 COMMENT '点赞数',
  `send_time` timestamp NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`m_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 91 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES (61, 43, 'hzh', 'http://tmp/0ldpX5rS9gXVd125c7a3d905523cc8027a56cb232d69.jpeg', '有点烦，都学期末了，一大堆事，还加上那些作业要赶', 0, '2021-12-14 20:45:37');
INSERT INTO `message` VALUES (26, 7, '小猪佩奇123', 'http://tmp/WuFTJeieTsZE4cff7eadb800a14a28fb99283e7209a9.jpeg', '2q14214', 3, '2021-12-02 10:21:00');
INSERT INTO `message` VALUES (59, 41, '郭伟豪', 'http://tmp/fAyOFncd4zQGfd9a38287ac7631930550523f3b7d788.jpeg', '我是guoweihao', 2, '2021-12-14 16:51:43');
INSERT INTO `message` VALUES (90, 62, '小可爱1', 'http://tmp/gdpkq2DsjiKS1b1a7f3bfe31ecc26a4a9e0a79dd902d.jpeg', '我是个小可爱', 2, '2022-02-04 22:49:20');
INSERT INTO `message` VALUES (62, 44, 'ylj', 'http://tmp/KrQfeEEEyp3C482dc4ad71bd9c98352c12ca8083f6c6.jpeg', '快学期末了，考完试就可以回外婆家，值得期待', 1, '2021-12-14 20:51:09');
INSERT INTO `message` VALUES (63, 45, '17308694632', 'http://tmp/CF3bgTvotHec2462add0511bc781c9aaa896c6b393be.jpeg', '心情不是很好，想去慢跑一下，吹吹晚风，听一些舒缓的歌曲\n', 3, '2021-12-14 20:53:32');

-- ----------------------------
-- Table structure for message_report
-- ----------------------------
DROP TABLE IF EXISTS `message_report`;
CREATE TABLE `message_report`  (
  `mr_id` int(50) NOT NULL AUTO_INCREMENT COMMENT '举报消息Id',
  `m_id` int(50) NOT NULL COMMENT '被举报的树洞消息',
  `u_id1` int(11) NOT NULL COMMENT '举报人的u_id',
  `u_id2` int(11) NOT NULL COMMENT '被举报人的u_id',
  `mr_content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '树洞消息举报说明',
  `mr_time` timestamp NOT NULL COMMENT '举报时间',
  PRIMARY KEY (`mr_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of message_report
-- ----------------------------
INSERT INTO `message_report` VALUES (13, 26, 40, 7, 'sfacz', '2021-12-14 16:46:14');
INSERT INTO `message_report` VALUES (17, 26, 42, 7, '的飒飒大大飒飒的', '2021-12-14 16:55:34');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `u_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '用户名',
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '手机号',
  `password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '密码',
  `face_url` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '用户头像地址',
  PRIMARY KEY (`u_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 64 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (7, '小猪佩奇123', '13411945045', '21218cca77804d2ba1922c33e0151105', 'http://tmp/WuFTJeieTsZE4cff7eadb800a14a28fb99283e7209a9.jpeg');
INSERT INTO `user` VALUES (46, '刘123', '13411945019', '21218cca77804d2ba1922c33e0151105', 'https://img2.baidu.com/it/u=395719964,2145680590&fm=26&fmt=auto');
INSERT INTO `user` VALUES (39, '123', '15322595888', 'e10adc3949ba59abbe56e057f20f883e', 'http://tmp/PvQeF2sdAdppba94608c25ed41ba963c86f4c131f6a7.jpeg');
INSERT INTO `user` VALUES (47, 'hhahh', '13531587181', 'e10adc3949ba59abbe56e057f20f883e', 'http://tmp/kjqdn6CxjURs71fd241e057fdd37fbb516bc433b4519.jpeg');
INSERT INTO `user` VALUES (62, '小可爱1', '13005416408', 'e10adc3949ba59abbe56e057f20f883e', 'http://tmp/gdpkq2DsjiKS1b1a7f3bfe31ecc26a4a9e0a79dd902d.jpeg');
INSERT INTO `user` VALUES (41, '郭伟豪', '15816763620', '13187c03a6f7ab04af485a97a0d82dbe', 'http://tmp/fAyOFncd4zQGfd9a38287ac7631930550523f3b7d788.jpeg');
INSERT INTO `user` VALUES (44, 'ylj', '18098142124', '03958af3f0642f3a2e38c24cb5ff5359', 'http://tmp/KrQfeEEEyp3C482dc4ad71bd9c98352c12ca8083f6c6.jpeg');
INSERT INTO `user` VALUES (45, '17308694632', '17308694632', 'e10adc3949ba59abbe56e057f20f883e', 'http://tmp/CF3bgTvotHec2462add0511bc781c9aaa896c6b393be.jpeg');
INSERT INTO `user` VALUES (42, '杀人犯', '15363398142', '82314331c932d3a4ba777103ef6968bc', 'http://tmp/XFUBT4IV7nUQ9fbcd57b7b808ed5b6ab021ebac18482.jpeg');
INSERT INTO `user` VALUES (43, 'hzh', '18098148434', 'e10adc3949ba59abbe56e057f20f883e', 'http://tmp/0ldpX5rS9gXVd125c7a3d905523cc8027a56cb232d69.jpeg');
INSERT INTO `user` VALUES (57, '路飞', '13411945055', 'e10adc3949ba59abbe56e057f20f883e', 'http://tmp/3bO4OGBpWALY98c019c053b7a9c87d9c43ca1a2e7e2f.webp');
INSERT INTO `user` VALUES (61, '龙猫', '13411945011', 'e10adc3949ba59abbe56e057f20f883e', 'http://tmp/j6XOObLCDt5lfe5d7a094bd8b6a94c64566642c4320b.webp');
INSERT INTO `user` VALUES (63, '1', '13411945056', 'e10adc3949ba59abbe56e057f20f883e', 'https://img2.baidu.com/it/u=395719964,2145680590&fm=26&fmt=auto');

SET FOREIGN_KEY_CHECKS = 1;
