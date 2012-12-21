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
    if (!file_exists(DATADICT_FILE)) {
        update();
    }

}

function update() {
    global $db, $cfg;

    $tables = array();

    $sql = sprintf("SHOW TABLES FROM `%s`", $cfg->db->dbname);
    while ($t = $db->query($sql)->fetchOne('num')) { // 获取所有表名
        $table = new stdClass();
        $table->name = $t[0];
        $tables[] = $table;
    }

    foreach ($tables as &$t) {
        $sql = "SELECT * FROM `INFORMATION_SCHEMA.TABLES` WHERE `table_name` = '%s'  AND `table_schema` = '%s'";
        $sql = sprintf($sql, $t->name, $cfg->db->dbname);

        while ($c = $db->query($sql)->fetchOne()) {

        }
    }

}