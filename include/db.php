<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-11-21
 * Time: 下午3:28
 * To change this template use File | Settings | File Templates.
 */

/**
 * 数据库操作类
 * 创建本类的实例之后，使用init()方法设置数据库连接信息
 * 无需显式调用connect()方法连接数据库，所有数据库操作前均检查连接状态，若未连接则会自动连接
 */
class Database {
    private $_host; //数据库主机
    private $_user; //数据库用户名
    private $_pass; //数据库密码
    private $_dbname; //数据库名
    private $_charset; //数据库编码

    private $_connected = false; //数据库连接状态
    private $_hdb; //数据库句柄
    private $_r; //查询结果

    private $_returnObj = false; //返回数组还是对象，默认返回数组

    /**
     * 初始化数据库连接信息
     * @param $host
     * @param $user
     * @param $pass
     * @param $dbname
     * @param string $charset
     */
    public function init($host, $user, $pass, $dbname, $charset = 'UTF8') {
        $this->_host = $host;
        $this->_user = $user;
        $this->_pass = $pass;
        $this->_dbname = $dbname;
        $this->_charset = $charset;
    }

    /**
     * 连接数据库
     * @return bool
     */
    public function connect() {
        if (empty($this->_host) || empty($this->_user) || empty($this->_pass) || empty($this->_dbname) || empty($this->_charset)) {
            return false;
        }
        $this->_hdb = mysql_connect($this->_host, $this->_user, $this->_pass) or die('Unable to connect to database!');
        mysql_query('SET NAMES ' . $this->_charset, $this->_hdb) or die ('MySQL Error on [SET CHARSET] query. ' . mysql_error());
        mysql_select_db($this->_dbname, $this->_hdb) or die ('MySQL Error on [SET DB] query. ' . mysql_error());

        $this->_connected = true;
        return true;
    }

    /**
     * 记录集中记录计数
     * @param $sql
     * @return int
     */
    public function count($sql) {
        if ($this->_r) {
            return mysql_num_rows($this->_r);
        }
        return false;
    }

    /**
     * 读取的行数据是否返回标准对象的开关，默认返回字段名为下标的数组
     * 可以串联使用,如 $db->query($sql)->returnObj(true)->fetchOne();
     * @param $returnObj 为真返回stdClass对象
     * @return Database
     */
    public function returnObj($returnObj = false) {
        $this->_returnObj = $returnObj;
        return $this;
    }

    /**
     * 获取记录集中的一行，可以通过returnObj()方法设定返回数组还是对象
     * @return array
     */
    public function fetchOne() {
        if ($this->_r) {
            $row = mysql_fetch_assoc($this->_r);
            if ($this->_returnObj) {
                $obj = new stdClass();
                foreach ($row as $k => $v) {
                    $obj->$k = $v;
                }
                return $obj;
            } else {
                return $row;
            }
        }
        return false;
    }

    /**
     * 获取记录集中的全部数据，以数组形式返回记录集每一行
     * @return array 失败返回空数组
     */
    public function fetchAll() {
        $rows = array();
        while ($row = $this->fetchOne()) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * MySQL Raw查询, 可以用于连贯操作，跟着其他的操作
     * @param $sql
     * @return resource
     */
    public function query($sql) {
        if (!$this->_connected) {
            $this->connect();
        }
        //$this->r = mysql_query($sql, $this->hdb) or die ('MySQL Error on [RAW] query. ' . mysql_error());
        $this->_r = $this->_log_query($sql, $this->_hdb); //数据库系统设计综合实验特殊设计
        return $this;
    }

    /**
     * 数据库插入操作封装，成功返回最后插入ID，失败返回假
     * @param $sql
     * @return bool|int
     */
    public function insert($sql) {
        if($this->query($sql)->affected_rows()) {
            return $this->last_id();
        } else {
            return false;
        }
    }

    /**
     * 数据库删除操作封装，删除后检查删除的记录数，不为0代表成功返回真，否则返回假
     * @param $sql
     * @return bool
     */
    public function delete($sql) {
        if ($this->query($sql)->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 数据库更新操作封装，更新后检查更新的记录数，不为0代表成功返回真，否则返回假
     * 注：MySQL 不会将原值和新值一样的列更新。这样使得 mysql_affected_rows()函数返回值不一定就是查询条件所符合的记录数，只有真正被修改的记录数才会被返回。
     * @param $sql
     * @return bool
     */
    public function update($sql) {
        //操作跟delete相同，先query再检查affected_rows
        if ($this->query($sql)->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 返回INSERT操作最后插入的自增ID
     * @return int
     */
    public function last_id() {
        if ($this->_hdb) {
            return mysql_insert_id($this->_hdb);
        }
        return false;
    }

    /**
     * 返回INSERT，UPDATE 或 DELETE 查询所影响的记录行数
     * @return int
     */
    public function affected_rows() {
        if ($this->_hdb) {
            return mysql_affected_rows($this->_hdb);
        }
        return false;
    }

    /**
     * sql字符串安全转义
     * @param $string
     * @return string
     */
    public function escape($string) {
        if (!$this->_connected) {
            $this->connect();
        }
        return mysql_real_escape_string($string, $this->_hdb);
    }

    /**
     * sql执行错误号
     * @return int
     */
    public function errno() {
        if ($this->_hdb) {
            return mysql_errno($this->_hdb);
        }
        return false;
    }

    /**
     * sql执行错误信息
     * @return string
     */
    public function errmsg() {
        if ($this->_hdb) {
            return mysql_error($this->_hdb);
        }
        return false;
    }

    /**
     * 关闭数据库连接
     * @return bool
     */
    public function close() {
        if ($this->_hdb) {
            mysql_close($this->_hdb);
            $this->_connected = false;
            $this->_hdb = false;
            return true;
        }
        return false;
    }

    /**
     * 数据库系统设计综合实验 特约函数——带日志记录的mysql_query
     * 记录信息：sql语句、执行耗时、当前时间、客户IP
     * @param $sql
     * @param $hdb
     * @return resource
     */
    private function _log_query($sql, $hdb) {
        $time_start = microtime_float();
        $r = mysql_query($sql, $hdb);
        $time_end = microtime_float();

        $log = new stdClass();
        $log->sql = $sql;
        $log->timestamp = time();
        $log->timespent = $time_end - $time_start;
        $log->ip = get_ip();

        //@todo: 这是一个很粗暴的日志记录实现方式，有待改进
        $logs = json_decode(file_get_contents(SQL_LOG_FILE), true);
        $logs[] = $log;
        file_put_contents(SQL_LOG_FILE, json_encode($logs));

        return $r;
    }
}