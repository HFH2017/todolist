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

/**
 * 删除用户的一个列表
 * @param $uid
 * @param $lid
 * @param bool $force 是否强制删除，默认为假，即当列表非空时默认不允许删除列表
 * @return bool
 */
function del_user_list($uid, $lid, $force = false) {
    global $db;

    if (!$force) { // 检查列表是否非空
        $l = get_user_tasks($uid, $lid);
        if (!empty( $l)) { // 列表下面的任务非空默认不能删除
            return false;
        }
    }
    $sql = "DELETE FROM `lists` WHERE `lid` = %d AND `list_uid` = %d";
    $sql = sprintf($sql, $lid, $uid);

    return $db->delete($sql);
}

function update_user_list($uid, $lid, $new_name) {
    global $db;

    $sql = "UPDATE `lists` SET `list_name` = %s WHERE `lid` = %d AND `list_uid` = %d";
    $sql = sprintf($sql, $new_name, $lid, $uid);

    return $db->update($sql);
}