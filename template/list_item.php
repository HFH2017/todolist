<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-24
 * Time: 下午9:09
 * To change this template use File | Settings | File Templates.
 *
 * @param $l: 一个列表条目，数据库lists表里面的一个条目
 * @param $_SESSION['default_lid']
 * @export $current_list_name: 当前列表标题
 */
    $class = '';
    $default = '';
    if( $l['lid'] == $_SESSION['current_lid'] ) {
        $current_list_name = $l['list_name'];
        $class='active';
    }
    if($l['lid'] == $_SESSION['default_lid']) {
        $default = 'default_list';
    }
?>
<li id="list-<?=$l['lid']?>" class="<?=$class?>">
    <a href="#" class="<?=$default?> clearfix">
        <i class="<?=$default? 'icon-tasks':'icon-align-justify'?>"></i>
        <span class="list_name"><?=$l['list_name']?></span>

        <span class="pull-right badge">
            <?=$l['list_tasks_count']?>
        </span>

        <? if($class): ?>
        <span class="pull-right"><i class="edit_list icon-gray icon-edit clickable"></i></span>
        <? endif; ?>
    </a>
</li>
