<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-21
 * Time: 下午4:06
 * To change this template use File | Settings | File Templates.
 */

include(dirname(__FILE__) . '/include/init.php');

if (!isset($_GET['action']) || !in_array($_GET['action'], array('update'))) {
    $_GET['action'] = 'index';
}
call_user_func($_GET['action']);

function index() {
    global $tpl;

    if (!file_exists(DATADICT_FILE)) {
        update();
    }
    $tables = json_decode(file_get_contents(DATADICT_FILE));
    $tpl->assign(array('tables' => $tables));
    $tpl->show('datadict');
}

function update() {
    global $db, $cfg;

    $tables = array();

    $sql = sprintf("SHOW TABLES FROM `%s`", $cfg->db->dbname);
    $db->query($sql);
    while ($t = $db->fetchOne('num')) { // 获取所有表名
        $table = new stdClass();
        $table->name = $t[0];
        $tables[] = $table;
    }

    foreach ($tables as &$t) {
        //取表注释
        $sql = "SELECT * FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `table_name` = '%s'  AND `table_schema` = '%s'";
        $sql = sprintf($sql, $t->name, $cfg->db->dbname);
        $db->query($sql);
        while ($c = $db->fetchOne()) {
            $t->comment = $c['TABLE_COMMENT'];
        }

        //取列
        $sql = "SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `table_name` = '%s'  AND `table_schema` = '%s'";
        $sql = sprintf($sql, $t->name, $cfg->db->dbname);

        $t->columns = $db->query($sql)->fetchAll('obj');
    }

    //save
    file_put_contents(DATADICT_FILE, json_encode($tables));
    redirect(get_baseurl(). '/datadict.php', 3, '已更新数据字典缓存，3秒后跳回数据字典页面');
}