<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-11-21
 * Time: 下午3:28
 * To change this template use File | Settings | File Templates.
 */

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/db.php');
include_once(dirname(__FILE__) . '/template.php');
include_once(dirname(__FILE__) . '/functions.php');

//全局通用对象
$db = new Database();
    $db->connect($cfg->db->host, $cfg->db->username, $cfg->db->password, $cfg->db->dbname);
$tpl = new Template();

//session
session_start();