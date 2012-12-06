<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-11-21
 * Time: 下午3:28
 * To change this template use File | Settings | File Templates.
 */

//加载系统基础库
include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/db.php');
include_once(dirname(__FILE__) . '/template.php');
include_once(dirname(__FILE__) . '/functions.php');

//加载应用函数库
include_once(dirname(dirname(__FILE__)) . '/library/libs_loader.php');

//全局通用对象
$db = new Database();
$db->init($cfg->db->host, $cfg->db->username, $cfg->db->password, $cfg->db->dbname);

$tpl = new Template();

//session
session_start();