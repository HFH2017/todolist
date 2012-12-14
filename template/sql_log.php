<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-3
 * Time: 上午10:47
 * To change this template use File | Settings | File Templates.
 */?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SQL执行日志 - 数据库系统设计综合实验</title>

    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/main.css">
    <link rel="stylesheet" type="text/css" href="static/css/shCore.css">
    <link rel="stylesheet" type="text/css" href="static/css/shThemeDefault.css">

    <script type="text/javascript" src="static/js/shCore.js"></script>
    <script type="text/javascript" src="static/js/shBrushSql.js"></script>
    <script type="text/javascript" src="static/js/bootstrap.min.js"></script>
    <style>
        body{background-color: #FFF;}
        .syntaxhighlighter .line {
            /*white-space: pre !important;*/
            white-space: pre-wrap !important;
            white-space: -moz-pre-wrap !important;
            white-space: -pre-wrap !important;
            white-space: -o-pre-wrap !important;
            word-wrap: break-word !important;
        }
        .syntaxhighlighter {
            overflow-y: hidden !important;
        }
        td {
            vertical-align: middle !important;
        }
    </style>
    <script type="text/javascript">
        SyntaxHighlighter.defaults['gutter'] = false;
        SyntaxHighlighter.defaults['toolbar'] = false;
        SyntaxHighlighter.all()
    </script>
</head>
<body>
<div class="container" style="margin-top: 5em;">
    <div class="row-fluid">
        <div class="t-center">
            <h2>Ultimate Todolist - 日志</h2>
            <hr>
        </div>
    </div>
    <div>
        <table class="table table-striped">
            <thead><tr><th style="width: 50px;">序号</th><th>SQL语句</th><th style="width: 90px;">执行耗时(S)</th><th style="width: 150px;">执行时间</th><th style="width: 100px;">客户端IP</th></tr></thead>
            <tbody>
                <?php while ($l = array_shift($logs)) : //@todo: 检查部署时候的Linux系统上是否需要手工做时区计算（+8） ?>
                <tr><td><?=$l['no']?></td><td><pre class="brush: sql"><?=$l['sql']?></pre></td><td><?=round($l['timespent'], 6)?></td><td><?=date('Y-m-d H:i:s', $l['timestamp'])?></td><td><?=$l['ip']?></td></tr>
                <?endwhile; ?>
            </tbody>
        </table>
        <div class="pagination_area">

            <form name="page_chooser" class="form-inline" style="text-align: center;">
                <?php if ($cur_page > 1) : ?><a class="btn" href="?p=<?=$cur_page - 1?>">上一页</a><?php endif; ?>
                <select name="page_no" style="width: 100px;" onchange="javascript: location.href=page_chooser.page_no.options[selectedIndex].value">
                    <?php for($i = 1; $i <= $total; $i++):?><option <?= $i == $cur_page ? 'selected' : ''?> value="?p=<?=$i?>" ><?php printf("第%d页", $i); ?></option>
                    <? endfor;?>
                </select>
                <?php if ($cur_page < $total) : ?><a class="btn" href="?p=<?=$cur_page + 1?>">下一页</a><?php endif; ?>
            </form>
        </div>
    </div>
    <?php include(dirname(__FILE__) . '/footer.php'); ?>
</div>

</body>
</html>