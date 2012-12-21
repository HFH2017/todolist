<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-2
 * Time: 下午6:45
 * To change this template use File | Settings | File Templates.
 */
include(dirname(__FILE__) . '/include/init.php');

$logs =json_decode(file_get_contents(SQL_LOG_FILE), true);

foreach ($logs as $k => &$v) {
    $v['no'] = $k+1;    //加上序号
}

$logs = array_reverse($logs); //反序先输出最新的

$records_count = count($logs);

if (isset($_GET['p']) && is_numeric($_GET['p'])) { //已设置且格式符合
    $cur_page = (int) $_GET['p'];
} else {
    $cur_page = 1;  //默认页码
}

if ($cur_page > ceil($records_count / $cfg->log->pagesize)) { //不能大于最大页码
    $cur_page = 1;
}

$offset = ($cur_page - 1) * $cfg->log->pagesize;

$logs = array_slice($logs, $offset, $cfg->log->pagesize);   //切分部分

$tpl->assign(array(
    'logs' => $logs,
    'cur_page' => $cur_page,
    'total' => ceil($records_count / $cfg->log->pagesize)
));
$tpl->show('sql_log');