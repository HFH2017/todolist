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
    redirect(get_baseurl().'/login.php');
}

$tpl->assign(array(
    "lists" => get_user_lists($_SESSION['uid']),
    'user' => get_user($_SESSION['uid']),
    'tasks' => get_user_tasks($_SESSION['uid'], $_SESSION['current_lid'])
));
$tpl->show('index');
