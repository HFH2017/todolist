<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-2
 * Time: 下午6:45
 * To change this template use File | Settings | File Templates.
 */
include(dirname(__FILE__) . '/include/init.php');
$logs =json_decode(file_get_contents(dirname(__FILE__) . '/sql.log.json'), true);
foreach ($logs as $k => &$v) {
    $v['no'] = $k+1;
}

$tpl->assign(array('logs' => $logs));
$tpl->show('sql_log');

