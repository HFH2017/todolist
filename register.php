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
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['usermail'])) {
        header("Content-type: text/plain; charset=UTF-8");
        header("refresh:3;url=" . get_baseurl(). '/register.php');
        echo '用户名密码邮件均不能为空，3秒后跳回注册页面';
        exit;
    }
    if ($uid = register_user($_POST['username'], $_POST['usermail'], $_POST['password'])) { //@todo: 邮件通知用户，user_status字段的维护

        $_SESSION['login'] = $_POST['username'];    //注册完直接就是已登录状态
        $_SESSION['uid'] = $uid;
        $_SESSION['default_lid'] = get_user_default_lid($uid);
        header('Location: ' . get_baseurl());
    } else {  //插入有问题，可能情况是重复用户名或者电子邮件 @todo:前端ajax检查重复用户名和重复邮件
        header("Content-type: text/plain; charset=UTF-8");
        header("refresh:3;url=" . get_baseurl(). '/register.php');
        echo '使用了相同的用户名或电子邮件重复注册无效，3秒后跳回注册页面';
        exit;
    }
}