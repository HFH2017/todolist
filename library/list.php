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
 * 返回用户的一个列表
 * @param $uid
 * @param $lid
 * @return array
 */
function get_user_list($uid, $lid) {
    global $db;

    $sql = "SELECT * FROM `lists` WHERE `list_uid` = %d AND `lid` = %d";
    $sql = sprintf($sql, $uid, $lid);

    if ($list = $db->query($sql)->fetchOne()) {
        return $list;
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

/**
 * 修改用户列表名称
 * @param $uid
 * @param $lid
 * @param $new_name
 * @return bool
 */
function update_user_listname($uid, $lid, $new_name) {
    global $db;

    $sql = "UPDATE `lists` SET `list_name` = %s WHERE `lid` = %d AND `list_uid` = %d";
    $sql = sprintf($sql, $new_name, $lid, $uid);

    return $db->update($sql);
}

/**
 * 更新列表的任务计数
 * @param $lid
 * @param string $delta
 * @return bool
 */
function update_tasks_count($lid, $delta = '+1') {
    global $db;

    $sql = "UPDATE `lists` SET `list_tasks_count` = `list_tasks_count`%s WHERE `lid` = %d";
    $sql = sprintf($sql, $delta, $lid);

    return $db->update($sql);
}

/**
 * 取得列表条目结构关联数组
 * @return array
 */
function get_list_tmpl() {
    return array(
        'lid' => '',
        'list_name' => '',
        'list_uid' => '',
        'list_tasks_count' => ''
    );
}