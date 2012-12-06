<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-3
 * Time: 下午7:09
 * To change this template use File | Settings | File Templates.
 */

/**
 * 返回用户的列表们
 * @param $uid
 * @return array
 */
function get_user_lists($uid) {
    global $db;

    $sql = "SELECT * FROM `lists` WHERE `list_uid` = %d";
    $sql = sprintf($sql, $uid);

    if ($lists = $db->query($sql)->fetchAll()) {
        return $lists;
    } else {
        return array();
    }
}

/**
 * 创建指定用户的一个列表
 * @param $uid
 * @param $list_name
 * @return bool|int
 */
function new_user_list($uid, $list_name) {
    global $db;

    $sql = "INSERT INTO `lists` (`list_name`, `list_uid`) VALUES ('%s', %d)";
    $sql = sprintf($sql, $list_name, $uid);

    if ($lid = $db->insert($sql)) {
        return $lid;
    } else {
        return false;
    }
}

function del_user_list($uid, $lid) {

}