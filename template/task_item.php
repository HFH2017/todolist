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
<li id="task-id-<?=$t['tid']?>" class="task-item rad6">
    <div class="task-body clearfix">
        <div class="task-checkbox pull-left"><input class="checkbox" type="checkbox" <?=$t['task_finished'] ? 'checked': ''?>></div>
        <div class="task-title pull-left">
            <?=$t['task_finished'] ? '<del>': ''?>
            <span><a class="btn_set_title" href="#"><?=$t['task_name']?></a></span>
            <?=$t['task_finished'] ? '</del>': ''?>
        </div>

        <div class="task-note pull-right"><span class="hide"><?=($t['task_note'] != 'NULL') && !empty($t['task_note']) ? $t['task_note'] : '' ?></span>
            <a class="btn_set_note" href="#"><i class="<?=($t['task_note'] != 'NULL') && !empty($t['task_note']) ? 'icon-gray' : 'icon-smoke'?> icon-file"></i></a>
        </div>

        <div class="task-star pull-right"><a class="btn_add_star" href="#"><i class="<?=$t['task_stared']? 'icon-yellow icon-star': 'icon-smoke icon-star'?>"></i></a></div>
        <div class="deadline pull-right">
            <span<?=strtotime($t['task_deadline'])<time() ? ' class="overdue"': ''?>>
                <a class="btn_set_time" href="#">
                <?=strtotime($t['task_deadline']) == 0 ? '<i class="icon-smoke icon-time"></i>': $t['task_deadline']?>
                </a>
            </span>
        </div>
    </div>
</li>