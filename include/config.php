<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-11-21
 * Time: 下午3:28
 * To change this template use File | Settings | File Templates.
 */
if (!isset($cfg)) {
    $cfg = new stdClass();

    //配置数据库信息开始
    $cfg->db->host      = 'localhost'; //数据库主机
    $cfg->db->username  = '2010wwll'; //数据库用户名
    $cfg->db->password  = 'MZrABZFrvAvzdCrA'; //数据库密码
    $cfg->db->dbname    = '2010wwll_todolist'; //数据库名
    $cfg->db->prefix    = ''; //本系统数据表前缀
    $cfg->db->charset   = 'UTF8'; //数据库编码

    //配置站点信息点开始
    $cfg->site->url     = 'http://127.0.0.15'; //站点根目录对应的url

    $cfg->log->pagesize = 20;


}

//模板文件路径定义
if (!defined('TPL_ROOT_PATH')) define('TPL_ROOT_PATH', dirname(dirname(__FILE__)).'/template');
if (!defined('TPL_FILE_EXT')) define('TPL_FILE_EXT', '.php');

//数据库操作日志存放文件
if (!defined('SQL_LOG_FILE')) define('SQL_LOG_FILE', dirname(dirname(__FILE__)) . '/sql.log.json');

//时区设置
ini_set("date.timezone", 'Asia/Shanghai'); // 系统时区