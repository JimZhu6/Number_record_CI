# 基于CodeIgniter框架的练习项目



- 将文件移动到服务器目录里
- 运行`composer install`下载依赖包

项目将依赖**0号**数据库的三个`key`：

**demo.cc:login_list**		存储登录用户信息
**demo.cc:telephone_list**	存储添加的号码
**demo.cc:marked_list**		存储标记的号码

其中，`demo.cc:login_list`需要先在redis-cli**手动创建**一个hash类型的登录用账号：

```shell
127.0.0.1:6379> hmset demo.cc:login_list username root password 1234
```

其中：`root`与`1234`对应为你自己定义的登录账号及其密码。