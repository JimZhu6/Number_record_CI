# 基于CodeIgniter框架的练习项目



## 项目运行

---

- 将文件移动到服务器目录里
- 运行`composer install`下载依赖包



项目将依赖Redis**0号**数据库的两个`key`：

- **demo.cc:telephone_list**	存储添加的号码
- **demo.cc:marked_list**		存储标记的号码以及标记信息

登录用户的信息将存储在MySQL数据库。

数据库生成语句：

```sql
-- ----------------------------
-- Table structure for user_list
-- ----------------------------
DROP TABLE IF EXISTS `user_list`;
CREATE TABLE `user_list` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`user_name`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`password`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`is_active`  tinyint(4) NOT NULL DEFAULT 1 ,
PRIMARY KEY (`id`),
UNIQUE INDEX `user_name` (`user_name`) USING BTREE 
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=2
;
-- ----------------------------
-- Auto increment value for user_list
-- ----------------------------
ALTER TABLE `user_list` AUTO_INCREMENT=2;
-- ----------------------------
-- Records of user_list
-- ----------------------------
BEGIN;
INSERT INTO `user_list` VALUES ('1', 'root', '1234', '1');
COMMIT;
```



## 项目逻辑

---

1. 使用基于CI视图的方式构建前端页面，页面位于`application/views/`。
2. 使用`application/models/Login_authentication_model.php`模块处理登录逻辑。
3. 使用`application/models/Number_record_model.php`模块处理项目主要逻辑。
4. 自行新建了两个类库分别操作`MySql`与`Redis`，位于`application/libraries/`。