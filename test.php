<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-10
 * Time: 上午10:47
 * To change this template use File | Settings | File Templates.
 */
include_once(dirname(__FILE__) . '/include/init.php');

print_r($db->query("DESCRIBE `tasks`")->fetchALL());