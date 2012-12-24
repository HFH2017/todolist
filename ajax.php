<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-24
 * Time: 下午2:30
 * To change this template use File | Settings | File Templates.
 */

include(dirname(__FILE__) . '/include/init.php');

//允许的动作列表
if (!isset($_GET['action']) || !in_array($_GET['action'], array(
    'add_task',
    'add_list',
    'load_tasks'
))) {
    err("Invalid Action");
}
call_user_func($_GET['action']);

/**
 * 添加todo
 * @internal param $_SESSION ['uid']
 * @internal param $_SESSION['current_lid']
 * @internal param $_GET['task_title']
 */
function add_task() {
    global $tpl;
    if($tid = new_user_task($_SESSION['uid'], $_SESSION['current_lid'], $_GET['task_title'])) {
        $t = get_task_tmpl();
        $t['tid'] = $tid;
        $t['task_name'] = $_GET['task_title'];
        $t['task_lid'] = $_SESSION['current_lid'];
        $t['task_uid'] = $_SESSION['uid'];

        $tpl->assign(array('t' => $t));
        $tpl->show('task_item');
    }
}

/**
 * 添加列表
 * @internal param $_SESSION ['uid']
 * @internal param $_GET['list_title']
 */
function add_list() {
    global $tpl;
    if($lid = new_user_list($_SESSION['uid'], $_GET['list_title'])) {
        $t = get_list_tmpl();
        $t['lid'] = $lid;
        $t['list_name'] = $_GET['list_title'];
        $t['list_tasks_count'] = 0;
        $t['task_uid'] = $_SESSION['uid'];

        $tpl->assign(array('l' => $t));
        $tpl->show('list_item');
    } else {
        err('Title invalid');
    }
}

function load_tasks() {
    global $tpl;
    if (!preg_match('/list-(\d+)/', $_GET['list_id'], $r)) {
        err('List id invalid');
    }
    if (!$list = get_user_list($_SESSION['uid'], $r[1])) {
        err('List not found');
    }
    $_SESSION['current_lid'] = $list['lid'];
    if ($tasks = get_user_tasks($_SESSION['uid'], $list['lid'])) {
        $tpl->assign(array('current_list_name' => $list['list_name'], 'tasks' => $tasks));
        $tpl->show('index_content');
    } else {
        $tpl->assign(array('current_list_name' => $list['list_name'], 'tasks' => array()));
        $tpl->show('index_content');
    }
}