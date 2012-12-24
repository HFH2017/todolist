<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-3
 * Time: 下午7:27
 * To change this template use File | Settings | File Templates.
 *
 * @param $user: 当前条目，数据库users表里面的一个条目
 * @param $lists: 用户列表
 * @param $tasks: 当前用户当前列表任务
 * @param $current_list_name
 */
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Todolist - 数据库系统设计综合实验</title>

    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/main.css">
    <script type="text/javascript" src="static/js/jquery.min.js"></script>
    <script type="text/javascript" src="static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="static/js/main.js"></script>
</head>
<body style="overflow: hidden;">

<div class="header">
    <div class="navbar navbar-fixed-top" style="margin-bottom: 0;">
        <div class="navbar-inner">
            <div style="margin-left: 20px;">
                <a class="brand" href="#">Ultimate List - 今天</a>
            </div>

            <ul class="nav pull-right">
                <li><a class="#">Today</a></li>
                <li><a class="#">Stared</a></li>
                <li><a class="#">deadlined</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?=$user['user_name']?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a>系统说明</a></li>
                        <li><a href="#">修改密码</a></li>
                        <li class="divider"></li>
                        <li><a href="login.php?action=logout">退出登录</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div>
    <div id="sidebar">
        <ul class="lists nav nav-tabs nav-stacked" style="margin-bottom: 0;">
            <?php foreach($lists as $l):?>
            <? include(TPL_ROOT_PATH. '/list_item.php'); ?>
            <?php endforeach; ?>
        </ul>
        <div id="add_list">
            <a class="btn btn-block" href="#dlg_add_list" data-toggle="modal"><i class="icon-plus icon-gray"></i> 添加列表</a>
        </div>

    </div>
    <div id="content">
        <? include(TPL_ROOT_PATH . '/index_content.php'); ?>
    </div>
</div>
<? include(TPL_ROOT_PATH . '/modals.php'); ?>
</body>
</html>