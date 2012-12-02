<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-2
 * Time: 下午6:45
 * To change this template use File | Settings | File Templates.
 */
var_dump(json_decode(file_get_contents(dirname(__FILE__) . '/sql.log.json'), true));