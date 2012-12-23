<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-10
 * Time: 上午10:47
 * To change this template use File | Settings | File Templates.
 */
include_once(dirname(__FILE__) . '/include/init.php');

$sql = "SHOW TABLES FROM `2010wwll\_todolist`";
while ($ta = $db->query($sql)->fetchOne('obj')) { // 获取所有表名
    $table = new stdClass();
    $table->name = $ta[0];
    $tables[] = $table;
}
var_dump($tables);
