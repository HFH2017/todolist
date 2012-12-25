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
    'add_task', //添加任务
    'add_list', //添加列表
    'load_tasks', //加载任务列表
    'toggle_star', //开关星标
    'toggle_task', //开关任务完成
    'edit_list', //编辑列表名称
    'load_task', //获取任务详细信息
    'get_lists', //取得用户列表信息
    'list_name', //取得列表的名字
    'update_title', //更新任务标题
    'update_note', //更新任务附注
    'update_deadline', //更新任务deadline
    'load_tasks_today', //加载今天及以前过期的任务
    'load_tasks_stared', //加载所有加星的任务
    'load_task_week', //加载未来7天任务
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

/**
 * 加载任务
 * @internal param $_SESSION ['uid']
 * @internal param $_GET['list_id']
 * @export param $_SESSION['current_lid']
 */
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

/**
 * 开关一个任务的星标
 * @internal param $_SESSION ['uid']
 * @internal param $_GET['task_id']
 */
function toggle_star() {
    if (!preg_match('/task-id-(\d+)/', $_GET['task_id'], $r)) {
        err('Task id invalid');
    }
    if(user_task_toggle_star($_SESSION ['uid'], $r[1])) {
        echo 'OK';
    } else {
        err('Task not found');
    }
}

/**
 * 开关一个任务的完成状态
 * @internal param $_SESSION ['uid']
 * @internal param $_GET['task_id']
 */
function toggle_task() {
    if (!preg_match('/task-id-(\d+)/', $_GET['task_id'], $r)) {
        err('Task id invalid');
    }
    if(user_task_toggle($_SESSION ['uid'], $r[1])) {
        echo 'OK';
    } else {
        err('Task not found');
    }
}

/**
 * 添加列表
 * @internal param $_SESSION ['uid']
 * @internal param $_GET['list_title']
 * @internal param $_SESSION['current_lid']
 */
function edit_list() {
    if (update_user_listname($_SESSION ['uid'], $_SESSION['current_lid'], $_GET['list_title'])) {
        echo $_GET['list_title'];
    } else {
        err('List name invalid');
    }
}

/**
 * 获取任务详细信息
 * @internal param $_SESSION ['uid']
 * @internal param $_GET['task_id']
 */
function load_task() {
    global $tpl;
    if (!preg_match('/task-id-(\d+)/', $_GET['task_id'], $r)) {
        err('Task id invalid');
    }
    if ($task = get_task_detail($_SESSION ['uid'], $r[1])) {
        $tpl->assign(array('t' => $task));
        $tpl->show('task_detail');
    } else {
        err('Task not found');
    }
}

/**
 * 获取列表信息，用于下拉框
 * @internal param $_SESSION ['uid']
 */
function get_lists() {
    if($lists = get_user_lists($_SESSION ['uid'], 'obj')) {
        foreach($lists as &$l) {
            $t = new stdClass();
            $t->text = $l->list_name;
            $t->value = $l->lid;

            $l = $t;
        }
        echo json_encode($lists);
    }
}

/**
 * 获取列表名字，用于下拉框
 * @internal param $_SESSION ['uid']
 * @internal param $_GET['list_id']
 */
function list_name() {
    if (!preg_match('/list-(\d+)/', $_GET['list_id'], $r)) {
        err('List id invalid');
    }
    echo get_list_name($r[1]);
}

/**
 * 更新任务注释
 */
function update_note() {
    update_title();
}

/**
 * 更新任务时限
 */
function update_deadline() {
    update_title();
}

/**
 * 更新任务title / 统一程序
 * @internal param $_SESSION ['uid']
 * @internal param $_POST['name']
 * @internal param $_POST['pk']
 * @internal param $_POST['value']
 */
function update_title() {
    if (!preg_match('/task-id-(\d+)/', $_POST['pk'], $r)) {
        err('Task id invalid');
    }
    if ($_POST['name'] == 'task_title') {
        update_task_name($_SESSION ['uid'], $r[1], $_POST['value']);
    } else if ($_POST['name'] == 'task_deadline') {
        update_task_deadline($_SESSION ['uid'], $r[1], $_POST['value']);
    } else if ($_POST['name'] == 'task_note') {
        update_task_note($_SESSION ['uid'], $r[1], $_POST['value']);
        echo $_POST['value'];
    }
}


function load_tasks_today() {
    global $tpl;
    if ($tasks = get_user_tasks_today($_SESSION['uid'])) {
        $tpl->assign(array('hide_add_task' => 1, 'tasks' => $tasks));
        $tpl->show('index_content');
    } else {
        $tpl->assign(array('hide_add_task' => 1, 'tasks' => array()));
        $tpl->show('index_content');
    }
}

function load_tasks_stared() {
    global $tpl;
    if ($tasks = get_user_tasks_stared($_SESSION['uid'])) {
        $tpl->assign(array('hide_add_task' => 1, 'tasks' => $tasks));
        $tpl->show('index_content');
    } else {
        $tpl->assign(array('hide_add_task' => 1, 'tasks' => array()));
        $tpl->show('index_content');
    }
}

function load_task_week() {
    global $tpl;
    if ($tasks = get_user_tasks_7day($_SESSION['uid'])) {
        $tpl->assign(array('hide_add_task' => 1, 'tasks' => $tasks));
        $tpl->show('index_content');
    } else {
        $tpl->assign(array('hide_add_task' => 1, 'tasks' => array()));
        $tpl->show('index_content');
    }
}