<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-3
 * Time: 下午8:20
 * To change this template use File | Settings | File Templates.
 */

/**
 * 取得用户信息
 * @param $uid
 * @return array
 */
function get_user($uid) {
    global $db;

    $sql = "SELECT * FROM `users` WHERE `uid` = %d";
    $sql = sprintf($sql, $uid);

    if ($user = $db->query($sql)->fetchOne()) {
        return $user;
    } else {
        return array();
    }
}

/**
 * 检查用户登录凭据
 * @param $user_login 邮件或用户名
 * @param $user_pass
 * @return bool|array 成功返回用户信息，失败返回假
 */
function chk_user_login($user_login, $user_pass) {
    global $db;

    $sql =  "SELECT * FROM `users` WHERE `user_name`='%s' OR `user_email`='%s' and `user_password`='%s'";
    $sql = sprintf($sql, $db->escape($user_login), $db->escape($user_login), md5(md5($user_pass))); //double md5


    if ($user = $db->query($sql)->fetchOne()) {
        return $user;
    } else {
        return false;
    }
}

/**
 * 注册用户
 * @param $user_name
 * @param $user_mail
 * @param $user_pass 用户的明文密码，hash操作在本函数内进行
 * @return bool
 */
function register_user($user_name, $user_mail, $user_pass) {
    global $db;

    $sql =  "INSERT INTO `users` (`user_name`, `user_password`, `user_email`, `user_register_time`, `user_last_login`)
             VALUES ('%s', '%s', '%s', NOW(), NOW())";
    $sql = sprintf($sql, $db->escape($user_name), md5(md5($user_pass)), $db->escape($user_mail)); //double md5

    if ($uid = $db->insert($sql)) {
        init_user_data($uid);
        return $uid;
    } else {
        return false;
    }
}

/**
 * 新用户的数据初始化，建立初始的列表和任务数据
 * @param $uid
 * @return bool|int 返回默认列表ID
 */
function init_user_data($uid) {
    $lid = new_user_list($uid, '默认列表');
    set_user_default_lid($uid, $lid);

    new_user_task($uid, $lid, '这是一个默认的任务'); //@todo: 完善初始化数据  前端界面 图片 尽快 从简
    new_user_task($uid, $lid, '任务还可以加星标', 1);
    new_user_task($uid, $lid, '本任务已完成，别管我', 0, 1);
    new_user_task($uid, $lid, '这个任务带有截止时间，就是今天', 0, 0, date("Y-m-d"));
    new_user_task($uid, $lid, '这个任务还有附注信息', 0, 0, 0, '我是附注信息啦');
    return $lid;

}

/**
 * 设置用户的默认列表ID
 * @param $uid
 * @param $lid
 * @return bool
 */
function set_user_default_lid($uid, $lid) {
    global $db;

    $sql = "UPDATE `users` SET `user_default_lid` = '%d' WHERE  `uid` =%d";
    $sql = sprintf($sql, $uid, $lid);

    return $db->update($sql);
}

/**
 * 获取用户的默认列表ID
 * @param $uid
 * @return bool
 */
function get_user_default_lid($uid) {
    global $db;

    $sql = "SELECT `user_default_lid` FROM `users` WHERE `uid` =%d";
    $sql = sprintf($sql, $uid);


    $d_lid = $db->query($sql)->returnObj(true)->fetchOne()->user_default_lid;
    $db->returnObj(false);

    return $d_lid;
}