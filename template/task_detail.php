<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-25
 * Time: 下午4:51
 * To change this template use File | Settings | File Templates.
 *
 * @param $t 一条任务信息
 */
//var_dump($t);?>
<div class="well">
    <div><span>任务名称：</span><a href="#" id="task_name"><?=$t['task_name']?></a></div>
    <div><span>任务期限：</span><a href="#" id="task_deadline"><?=strtotime($t['task_deadline']) == 0 ? '未设定': $t['task_deadline']?></a></div>
    <div><span>任务状态：</span>
        <span class="task-checkbox"><input class="checkbox" type="checkbox" <?=$t['task_finished'] ? 'checked': ''?>></span>
        <span class="task-star"><a class="btn_add_star" href="#"><i class="<?=$t['task_stared']? 'icon-yellow icon-star': 'icon-smoke icon-star'?>"></i></a></span>
    </div>
    <div><span>所属列表：</span><a href="#" id="task_lid"><?=get_list_name($t['task_lid'])?></a></div>
    <div><span>任务详情：</span>
        <a href="#" id="task_note"><?=$t['task_note'] != 'NULL' ? $t['task_note']: '未设定'?></a>
    </div>
</div>
