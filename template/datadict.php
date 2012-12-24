<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-23
 * Time: 上午10:19
 * To change this template use File | Settings | File Templates.
 *
 * @param $tables: 数据表信息
 */?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>数据字典 - 数据库系统设计综合实验</title>

    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/main.css">

</head>
<body>
<div class="container" style="margin-top: 5em;">
    <div class="row-fluid">
        <div class="t-center">
            <h2>Ultimate Todolist - 数据字典</h2>
            <hr>
        </div>
    </div>
    <? foreach($tables as $t): ?>
    <div>
        <h2><?=$t->name;?> <small><?=$t->comment?></small></h2>
        <table class="table table-striped">
            <thead><tr><th>#</th><th style="width: 20%;">字段</th><th>类型</th><th>允许空</th><th>默认值</th><th>额外</th><th style="width: 20%;">注释</th></tr></thead>
            <tbody>
            <?php foreach ($t->columns as $c) :?>
            <tr>
                <td><?=$c->ORDINAL_POSITION?></td>
                <td><?=$c->COLUMN_KEY == 'PRI' ? "<b>$c->COLUMN_NAME</b>" : $c->COLUMN_NAME ?></td>
                <td><?=$c->COLUMN_TYPE?></td>
                <td><?=$c->IS_NULLABLE?></td>
                <td><?=$c->COLUMN_DEFAULT?></td>
                <td><?=$c->EXTRA?></td>
                <td><?=$c->COLUMN_COMMENT?></td>
            </tr>
            <? endforeach; ?>
            </tbody>
        </table>
    </div>
    <? endforeach; ?>
    <?php include(dirname(__FILE__) . '/footer.php'); ?>
</div>

</body>
</html>