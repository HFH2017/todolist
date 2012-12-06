<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-3
 * Time: 下午7:27
 * To change this template use File | Settings | File Templates.
 */
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Todolist - 数据库系统设计综合实验</title>

    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/main.css">
    <script type="text/javascript" src="static/js/jquery.min.js"></script>
    <script type="text/javascript" src="static/js/bootstrap.min.js"></script>
</head>
<body>
<div>
        <div id="sidebar" class="span3">
            <ul class="nav nav-pills nav-stacked">
                <?php foreach($lists as $l):?>
                <li><?=$l['list_name']?></li>
                <?php endforeach; ?>
                <li><a class="btn btn-primary btn-small">添加列表</a></li>
            </ul>
        </div>

</div>
<?php include(dirname(__FILE__) . '/footer_bar.php'); ?>

</body>
</html>