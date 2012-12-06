<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-3
 * Time: 下午7:09
 * To change this template use File | Settings | File Templates.
 */

/**
 * 取得某用户某个列表里面的全部任务
 * @param $uid
 * @param $lid
 * @return array
 */
function get_user_tasks($uid, $lid) {
    global $db;

    $sql = "SELECT * FROM `tasks` WHERE `task_uid` = %d AND `task_lid` = %d";
    $sql = sprintf($sql, $uid, $lid);

    if ($tasks = $db->query($sql)->fetchAll()) {
        return $tasks;
    } else {
        return array();
    }
}

/**
 * 添加用户任务
 * @param $uid
 * @param $lid
 * @param $task_name
 * @return bool|int 成功返回任务ID，失败返回假
 */
function new_user_task($uid, $lid, $task_name) {
    global $db;

    $sql = "INSERT INTO `tasks` (`task_name`, `task_uid`, `task_lid`, `task_ctime`) VALUES ('%s', %d, %d, NOW())";
    $sql = sprintf($sql, $task_name, $uid, $lid);

    if ($uid = $db->insert($sql)) {
        return $uid;
    } else {
        return false;
    }
}