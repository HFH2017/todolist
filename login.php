<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-11-21
 * Time: 下午3:28
 * To change this template use File | Settings | File Templates.
 */
include(dirname(__FILE__) . '/include/init.php');

if (!isset($_GET['action']) || !in_array($_GET['action'], array('chk_login'))) {
    $_GET['action'] = 'index';
}
call_user_func($_GET['action']);

function index() {
    global $tpl;
    $tpl->show('login');
}

function chk_login() {
    global $db, $cfg;
    if (empty($_POST['username']) || empty($_POST['password'])) {
        header("Content-type: text/plain; charset=UTF-8");
        header("refresh:3;url=" . get_baseurl());
        echo '用户名密码不能为空，3秒后跳回登陆页面';
        exit;
    }
    $sql =  "SELECT * FROM `%susers` WHERE `user_name`='%s' OR `user_email`='%s' and `password`='%s'";
    $sql = sprintf($sql, $cfg->db->prefix, $db->escape($_POST['username']), $db->escape($_POST['username']), md5(md5($_POST['password']))); //double md5

    if($db->count($sql)){
        $_SESSION['login'] = $_POST['username'];
        header('Location: ' . get_baseurl());
    } else {
        header("Content-type: text/plain; charset=UTF-8");
        header("refresh:3;url=" . get_baseurl());
        echo '用户名或密码错误，3秒后跳回登陆页面';
        exit;
    }
}