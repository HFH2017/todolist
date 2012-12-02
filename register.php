<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-11-21
 * Time: 下午3:28
 * To change this template use File | Settings | File Templates.
 */
include(dirname(__FILE__) . '/include/init.php');

if (!isset($_GET['action']) || !in_array($_GET['action'], array('chk_register'))) {
    $_GET['action'] = 'index';
}
call_user_func($_GET['action']);

function index() {
    global $tpl;
    $tpl->show('register');
}

function chk_register() {
    global $db, $cfg;
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['usermail'])) {
        header("Content-type: text/plain; charset=UTF-8");
        header("refresh:3;url=" . get_baseurl(). '/register.php');
        echo '用户名密码邮件均不能为空，3秒后跳回注册页面';
        exit;
    }
    $sql =  "INSERT INTO `%susers` (`user_name`, `user_password`, `user_email`, `user_register_time`, `user_last_login`) VALUES ('%s', '%s', '%s', NOW(), NOW())";
    $sql = sprintf($sql, $cfg->db->prefix, $db->escape($_POST['username']), md5(md5($_POST['password'])), $db->escape($_POST['usermail'])); //double md5
    $db->query($sql);

    if($db->affected_rows() == 1){ //@todo: 邮件通知用户，user_status字段的维护
        $_SESSION['login'] = $_POST['username'];    //注册完直接就是已登录状态
        $_SESSION['uid'] = $db->last_id();
        header('Location: ' . get_baseurl());
    } else {  //插入有问题，可能情况是重复用户名或者电子邮件 @todo:前端ajax检查重复用户名和重复邮件
        header("Content-type: text/plain; charset=UTF-8");
        header("refresh:3;url=" . get_baseurl(). '/register.php');
        echo '使用了相同的用户名或电子邮件重复注册无效，3秒后跳回注册页面';
        exit;
    }
}