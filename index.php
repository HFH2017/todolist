<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-11-21
 * Time: 下午3:28
 * To change this template use File | Settings | File Templates.
 */
include(dirname(__FILE__) . '/include/init.php');

if (!check_login()) {
    header('Location: ' . get_baseurl().'/login.php');
    exit;
}
echo '已登录';
