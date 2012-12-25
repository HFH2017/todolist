Ultimate Todolist
========
数据库原理课程 综合实验

小组成员：2010级软件工程 王旭红、温小虎、廖利纯、黎欣健

参考原型：[Wunderlist](http://www.wunderlist.com)

本系统前端测试环境为：Chrome 23 + Win7，未测试在其他平台其他浏览器中的兼容性

## 文件结构
* ###### 根目录
    + ajax.php  全站ajax提交接收入口
    + datadict.php 数据字典页入口
    + index.php  首页页入口
    + login.php  登陆页入口
    + register.php 注册页入口
    + sqllog.php SQL日志页入口
* ###### data 数据文件及缓存
    + sql.log.json  SQL日志
    + datadict.json 数据字典缓存
    + 2010wwll_todolist.sql 数据库结构备份
* ###### include 系统基础框架
    + config.php 配置文件
    + db.php 数据库操作类
    + functions.php 函数库
    + init.php 系统初始化入口文件
    + template.php 模版类
* ###### library 应用函数库
    + list.php 列表操作函数库
    + task.php 任务操作函数库
    + user.php 用户操作函数库
    + libs_loader.php 应用函数库加载入口
* ###### static 静态资源 使用了Bootstrap和JQuery
* ###### template 模版文件

## 更新记录

#### 0.1
放出demo版本，目前支持的功能：注册，登陆，注销，添加列表，添加任务，切换列表，查看sql日志，查看数据字典

#### 0.2
* 新实现功能：列表重命名，任务星标开关，任务完成开关，任务名称、期限、备注的显示、修改，集合今天或以前过期的任务，聚合加星任务，聚合本周任务
* 修正：列表任务计数多1的bug