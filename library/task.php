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