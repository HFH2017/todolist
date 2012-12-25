<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-25
 * Time: 上午1:15
 * To change this template use File | Settings | File Templates.
 *
 * @param $current_list_name 当前列表名
 * @param $tasks 任务数组
 */
    $task_unfinished = array();
    $task_finished = array();
    foreach ($tasks as $t) {
        if(!$t['task_finished']) {
            $task_unfinished[] = $t;
        } else {
            $task_finished[] = $t;
        }
    }

?>
<? if(!isset($hide_add_task) || !$hide_add_task) : ?>
<div id="add_task">
    <form method="POST">
        <div class="input-append" >
            <input class="text" type="text" style="width: 85%;" placeholder="添加任务项目到 “<?=isset($current_list_name)? $current_list_name: ''?>”...">
            <button class="btn btn-primary" id="btn_add_todo" style="width: 10%;">添加Todo</button>
        </div>
    </form>
</div>
<? endif; ?>

<? if(!count($tasks)) : ?>
<div id="empty_list_tips" class="t-center heading-label-small">本列表中没有任务</div>
<? endif; ?>

<ul class="tasks">
    <? foreach($task_unfinished as $t) : ?>
    <? include(TPL_ROOT_PATH. '/task_item.php'); ?>
    <? endforeach;?>
</ul>

<? if(count($task_finished)) : ?>
<div class="heading-label-small">已完成的任务</div>
<? endif; ?>
<ul class="tasks finished ">
    <? foreach($task_finished as $t) : ?>
    <? include(TPL_ROOT_PATH. '/task_item.php'); ?>
    <? endforeach;?>
</ul>
