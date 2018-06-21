/*
 Navicat Premium Data Transfer

 Source Server         : 本地数据库
 Source Server Type    : MySQL
 Source Server Version : 50714
 Source Host           : localhost:3306
 Source Schema         : bjx_blog

 Target Server Type    : MySQL
 Target Server Version : 50714
 File Encoding         : 65001

 Date: 21/06/2018 10:11:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bjx_article
-- ----------------------------
DROP TABLE IF EXISTS `bjx_article`;
CREATE TABLE `bjx_article`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章标题',
  `author` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '作者',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户',
  `category_id` int(11) UNSIGNED NOT NULL COMMENT '分类id',
  `markdown` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'markdown文章内容',
  `keywords` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '关键词',
  `cover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面图',
  `is_show` tinyint(1) NULL DEFAULT 0 COMMENT '0不显示,1显示',
  `is_top` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '置顶',
  `recommend` tinyint(1) NULL DEFAULT 0 COMMENT '推荐',
  `click` int(255) NULL DEFAULT NULL COMMENT '点击',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `update_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bjx_article
-- ----------------------------
INSERT INTO `bjx_article` VALUES (1, '订单', '的是', 1, 2, '```php\n<?php\n	public function index(){\n		echo \"abc\";\n	}\n?>\n```\n', '大', 'http://localhost/bjxblog/tp5/public/images/article/1/xlT62231.png', 1, 0, 0, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for bjx_article_tag
-- ----------------------------
DROP TABLE IF EXISTS `bjx_article_tag`;
CREATE TABLE `bjx_article_tag`  (
  `article_id` int(11) NOT NULL COMMENT '文章id',
  `tag_id` int(11) NOT NULL COMMENT '标签id',
  PRIMARY KEY (`article_id`, `tag_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of bjx_article_tag
-- ----------------------------
INSERT INTO `bjx_article_tag` VALUES (1, 3);

-- ----------------------------
-- Table structure for bjx_category
-- ----------------------------
DROP TABLE IF EXISTS `bjx_category`;
CREATE TABLE `bjx_category`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类主键id',
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `sort` tinyint(1) NOT NULL DEFAULT 0 COMMENT '排序',
  `nav_show` tinyint(1) NOT NULL DEFAULT 0 COMMENT '导航显示：1显示，2不显示',
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '分类' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bjx_category
-- ----------------------------
INSERT INTO `bjx_category` VALUES (1, 'HTML', 'web前端', 0, 1, 1527649346, 1527649346, NULL);
INSERT INTO `bjx_category` VALUES (2, 'PHP', 'php', 0, 1, 1527652291, 1527652291, NULL);
INSERT INTO `bjx_category` VALUES (3, 'Python', 'Python', 0, 0, 1527652522, 1527676147, NULL);

-- ----------------------------
-- Table structure for bjx_comment
-- ----------------------------
DROP TABLE IF EXISTS `bjx_comment`;
CREATE TABLE `bjx_comment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '文章id',
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '用户id',
  `content` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '内容',
  `status` tinyint(1) NULL DEFAULT 0 COMMENT '状态：0屏蔽,1显示',
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `articleId`(`article_id`) USING BTREE,
  INDEX `userId`(`user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bjx_link
-- ----------------------------
DROP TABLE IF EXISTS `bjx_link`;
CREATE TABLE `bjx_link`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '友情链接名',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接地址',
  `favicon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图标地址',
  `sort` tinyint(255) UNSIGNED NULL DEFAULT NULL COMMENT '排序',
  `status` tinyint(1) UNSIGNED NULL DEFAULT NULL COMMENT '状态：0隐藏，1显示',
  `create_time` int(255) UNSIGNED NULL DEFAULT NULL,
  `update_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bjx_tag
-- ----------------------------
DROP TABLE IF EXISTS `bjx_tag`;
CREATE TABLE `bjx_tag`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标签名',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `update_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '标签' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bjx_tag
-- ----------------------------
INSERT INTO `bjx_tag` VALUES (1, 'js', 1527677036, 1527679204, NULL);
INSERT INTO `bjx_tag` VALUES (2, 'css', 1527677084, 1527679224, NULL);
INSERT INTO `bjx_tag` VALUES (3, 'ThinkPHP', 1527677192, 1527679272, NULL);

-- ----------------------------
-- Table structure for bjx_user
-- ----------------------------
DROP TABLE IF EXISTS `bjx_user`;
CREATE TABLE `bjx_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `scope` tinyint(4) NULL DEFAULT NULL COMMENT '权限值',
  `status` tinyint(4) NULL DEFAULT NULL COMMENT '状态',
  `login_time` int(11) NULL DEFAULT NULL COMMENT '最近登录',
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bjx_user
-- ----------------------------
INSERT INTO `bjx_user` VALUES (1, 'binjuxing', '004bad429c807afbbc6782ea933b6238', 'Jayson', 99, 1, NULL, 1526908053, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
