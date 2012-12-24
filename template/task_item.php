<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-24
 * Time: 下午9:04
 * To change this template use File | Settings | File Templates.
 *
 * @param $t: 一个任务条目，数据库tasks表里面的一个条目
 */?>
<li id= "task-id-<?=$t['tid']?>" class="task-item rad6">
    <div class="task-body clearfix">
        <div class="task-checkbox pull-left"><input class="checkbox" type="checkbox" <?=$t['task_finished'] ? 'checked': ''?>></div>
        <div class="task-title pull-left"><?=$t['task_finished'] ? '<del>': ''?><?=$t['task_name']?><?=$t['task_finished'] ? '</del>': ''?></div>
        <div class="task-star pull-right"><a><i class="<?=$t['task_stared']? 'icon-yellow icon-star': 'icon-smoke icon-star'?>"></i></a></div>
        <div class="task-note pull-right"><a><i class="<?=$t['task_note'] != 'NULL' ? 'icon-gray icon-file': ''?>"></i></a></div>
        <div class="deadline pull-right"><span<?=strtotime($t['task_deadline'])<time() ? ' class="overdue"': ''?>><?=strtotime($t['task_deadline']) == 0 ? '': $t['task_deadline']?></span></div>
    </div>
</li>