<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-3
 * Time: 下午7:27
 * To change this template use File | Settings | File Templates.
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
</head>
<body>

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
                        Username
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a>系统说明</a></li>
                        <li><a href="#">修改密码</a></li>
                        <li class="divider"></li>
                        <li><a href="#">退出登录</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div>
    <div id="sidebar">
        <ul class="nav nav-tabs nav-stacked" style="margin-bottom: 0;">
            <?php //foreach($lists as $l):?>
            <li><?//=$l['list_name']?></li>
            <?php //endforeach; ?>
            <li><a href="#">购买列表 <i class="icon-chevron-right"></i></a></li>
            <li><a href="#">书单</a></li>
            <li><a href="#">作业列表</a></li>
            <li><a href="#">购买列表</a></li>
            <li><a href="#">书单</a></li>
            <li><a href="#">作业列表</a></li>
            <li><a href="#">购买列表</a></li>
            <li><a href="#">书单</a></li>
            <li><a href="#">作业列表</a></li>
            <li><a href="#">购买列表</a></li>
            <li><a href="#">书单</a></li>
            <li><a href="#">作业列表</a></li>
            <li><a href="#">购买列表</a></li>
            <li><a href="#">书单</a></li>
            <li><a href="#">作业列表</a></li>
            <li><a href="#">购买列表</a></li>
            <li><a href="#">书单</a></li>
            <li><a href="#">作业列表</a></li>
            <li><a href="#">购买列表</a></li>
            <li><a href="#">书单</a></li>
            <li><a href="#">作业列表</a></li>
        </ul>
        <div id="add_list">
            <a class="btn btn-success btn-block"><i class="icon-plus icon-white"></i> 添加列表</a>
        </div>

    </div>
    <div id="content">
        <div id="add_task">
            <form method="POST">
                <div class="input-append" style="text-align: center;">
                <input class="text" type="text" style="width: 80%;">
                <button class="btn">添加Todo</button>
                </div>
            </form>
        </div>

        <ul id="tasks">
            <li>
                <span><input class="checkbox"></span>
                <span></span>
            </li>
        </ul>

    </div>
</div>

</body>
</html>