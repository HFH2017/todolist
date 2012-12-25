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

    $sql = "SELECT * FROM `tasks` WHERE `task_uid` = %d AND `task_lid` = %d ORDER BY `tid` DESC";
    $sql = sprintf($sql, $uid, $lid);

    if ($tasks = $db->query($sql)->fetchAll()) {
        return $tasks;
    } else {
        return array();
    }
}

/**
 * 取得某用户今天及以前过期的全部任务
 * @param $uid
 * @return array
 */
function get_user_tasks_today($uid) {
    global $db;

    $sql = "SELECT * FROM `tasks` WHERE `task_uid` = %d AND `task_deadline`<= NOW() AND  `task_deadline` !=0";
    $sql = sprintf($sql, $uid);

    if ($tasks = $db->query($sql)->fetchAll()) {
        return $tasks;
    } else {
        return array();
    }
}

function get_user_tasks_7day($uid) {
    global $db;

    $sql = "SELECT * FROM `tasks` WHERE `task_uid` = %d AND `task_deadline`<= DATE_ADD(NOW() , INTERVAL 7 DAY) AND  `task_deadline` !=0";
    $sql = sprintf($sql, $uid);

    if ($tasks = $db->query($sql)->fetchAll()) {
        return $tasks;
    } else {
        return array();
    }
}

function get_user_tasks_stared($uid) {
    global $db;

    $sql = "SELECT * FROM `tasks` WHERE `task_uid` = %d AND `task_stared`=1";
    $sql = sprintf($sql, $uid);

    if ($tasks = $db->query($sql)->fetchAll()) {
        return $tasks;
    } else {
        return array();
    }
}
/**
 * 取得用户的某个任务详细信息
 * @param $uid
 * @param $tid
 * @return array
 */
function get_task_detail($uid, $tid) {
    global $db;

    $sql = "SELECT * FROM `tasks` WHERE `task_uid` = %d AND `tid` = %d";
    $sql = sprintf($sql, $uid, $tid);

    if ($task = $db->query($sql)->fetchOne()) {
        return $task;
    } else {
        return array();
    }
}

/**
 * 更新任务标题
 * @param $uid
 * @param $tid
 * @param $new_title
 * @return bool
 */
function update_task_name($uid, $tid, $new_title) {
    global $db;

    $sql = "UPDATE `tasks` SET `task_name` = '%s' WHERE `tid` = %d AND `task_uid` = %d";
    $sql = sprintf($sql, $db->escape($new_title), $tid, $uid);

    return $db->update($sql);
}

/**
 * 更新任务附注
 * @param $uid
 * @param $tid
 * @param $new_note
 * @return bool
 */
function update_task_note($uid, $tid, $new_note) {
    global $db;

    $sql = "UPDATE `tasks` SET `task_note` = '%s' WHERE `tid` = %d AND `task_uid` = %d";
    $sql = sprintf($sql, $db->escape($new_note), $tid, $uid);

    return $db->update($sql);
}

/**
 * 更新任务期限
 * @param $uid
 * @param $tid
 * @param $new_deadline
 * @return bool
 */
function update_task_deadline($uid, $tid, $new_deadline) {
    global $db;

    $sql = "UPDATE `tasks` SET `task_deadline` = '%s' WHERE `tid` = %d AND `task_uid` = %d";
    $sql = sprintf($sql, $db->escape($new_deadline), $tid, $uid);

    return $db->update($sql);
}

/**
 * 添加用户任务
 * @param $tid
 * @param $lid
 * @param $task_name
 * @param bool $is_stared 是否加星标，可空默认为假
 * @param bool $is_finished 是否已完成，可空默认为假
 * @param string $task_deadline 任务deadline，可空默认不设
 * @param string $task_note 任务注释，可空默认不设
 * @param bool $update_count 是否自动更新列表任务数量计数，默认为真，如果批量加入任务可以手动更新
 * @return bool|int 成功返回任务ID，失败返回假
 */
function new_user_task($tid, $lid, $task_name, $is_stared = false, $is_finished = false, $task_deadline = '', $task_note = '', $update_count = true) {
    global $db;

    $is_stared = empty($is_stared) ? 0 : 1;
    $is_finished = empty($is_finished) ? 0 : 1;
    $task_deadline = empty($task_deadline) ? 'NULL' : $task_deadline;
    $task_note = empty($task_note) ? 'NULL' : $task_note;


    $sql = "INSERT INTO `tasks` (`task_name`, `task_uid`, `task_lid`, `task_ctime`, `task_stared`, `task_finished`, `task_deadline`, `task_note`)
            VALUES ('%s', %d, %d, NOW(), %d, %d, '%s', '%s')";
    $sql = sprintf($sql, $db->escape($task_name), $tid, $lid, $is_stared, $is_finished, $task_deadline, $db->escape($task_note));

    if ($tid = $db->insert($sql)) {
        if ($update_count) {
            update_tasks_count($lid);
        }
        return $tid;
    } else {
        return false;
    }
}

/**
 * 开关用户任务的星标
 * @param $uid
 * @param $tid
 * @return bool
 */
function user_task_toggle_star($uid, $tid) {
    global $db;

    $sql = "UPDATE `tasks` SET `task_stared` = 1 - `task_stared` WHERE `tid` = %d AND `task_uid` = %d";
    $sql = sprintf($sql, $tid, $uid);

    return $db->update($sql);
}

/**
 * 开关用户任务的完成状态
 * @param $uid
 * @param $tid
 * @return bool
 */
function user_task_toggle($uid, $tid) {
    global $db;

    $sql = "UPDATE `tasks` SET `task_finished` = 1 - `task_finished` WHERE `tid` = %d AND `task_uid` = %d";
    $sql = sprintf($sql, $tid, $uid);

    return $db->update($sql);
}

/**
 * 取得任务条目结构关联数组
 * @return array
 */
function get_task_tmpl() {
    return array(
        'tid' => '',
        'task_name' => '',
        'task_stared' => '0',
        'task_finished' => '0',
        'task_deadline' => '0',
        'task_ctime' => '0',
        'task_note' => 'NULL',
        'task_lid' => '',
        'task_uid' => '',
    );
}