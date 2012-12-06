<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-11-21
 * Time: 下午3:28
 * To change this template use File | Settings | File Templates.
 */
include(dirname(__FILE__) . '/include/init.php');

if (!check_login()) { //登陆检查
    header('Location: ' . get_baseurl().'/login.php');
    exit;
}

//加载应用函数库
include(dirname(__FILE__) . '/library/libs_loader.php');

$tpl->assign(array(
    "lists" => get_user_lists($_SESSION['uid']),
    'user' => get_user($_SESSION['uid'])
));
$tpl->show('index');
