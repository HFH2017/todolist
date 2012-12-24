<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-11-21
 * Time: 下午3:28
 * To change this template use File | Settings | File Templates.
 */
include(dirname(__FILE__) . '/include/init.php');

if (!isset($_GET['action']) || !in_array($_GET['action'], array('chk_login', 'logout'))) {
    $_GET['action'] = 'index';
}
call_user_func($_GET['action']);

function index() {
    global $tpl;
    $tpl->show('login');
}

function chk_login() {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        redirect(get_baseurl(), 3, '用户名密码不能为空，3秒后跳回登陆页面');
    }

    if($user = chk_user_login($_POST['username'], $_POST['password'])){
        user_login($user);
        redirect(get_baseurl());
    } else {
        redirect(get_baseurl(), 3, '用户名或密码错误，3秒后跳回登陆页面');
    }
}

function logout() {
    session_destroy();

    redirect('/', 5, '已退出登录，5秒后跳回登陆页面');
}