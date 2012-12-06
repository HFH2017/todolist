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
    private $host; //数据库主机
    private $user; //数据库用户名
    private $pass; //数据库密码
    private $dbname; //数据库名
    private $charset; //数据库编码

    private $connected = false; //数据库连接状态
    private $hdb; //数据库句柄
    private $r; //查询结果

    /**
     * 初始化数据库连接信息
     * @param $host
     * @param $user
     * @param $pass
     * @param $dbname
     * @param string $charset
     */
    public function init($host, $user, $pass, $dbname, $charset = 'UTF8') {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->charset = $charset;
    }

    /**
     * 连接数据库
     * @return bool
     */
    public function connect() {
        if (empty($this->host) || empty($this->user) || empty($this->pass) || empty($this->dbname) || empty($this->charset)) {
            return false;
        }
        $this->hdb = mysql_connect($this->host, $this->user, $this->pass) or die('Unable to connect to database!');
        mysql_query('SET NAMES ' . $this->charset, $this->hdb) or die ('MySQL Error on [SET CHARSET] query. ' . mysql_error());
        mysql_select_db($this->dbname, $this->hdb) or die ('MySQL Error on [SET DB] query. ' . mysql_error());

        $this->connected = true;
        return true;
    }

    /**
     * 记录集中记录计数
     * @param $sql
     * @return int
     */
    public function count($sql) {
        if ($this->r) {
            return mysql_num_rows($this->r);
        }
        return false;
    }

    /**
     * 获取记录集中的一行的关联数组
     * @return array
     */
    public function fetchOne() {
        if ($this->r) {
            return mysql_fetch_assoc($this->r);
        }
        return false;
    }

    /**
     * 获取记录集中的全部数据，以多维数组形式返回
     * @return array 失败返回空数组
     */
    public function fetchAll() {
        $rows = array();
        while ($row = $this->fetchOne()) {
            $row[] = $row;
        }
        return $rows;
    }

    /**
     * MySQL Raw查询, 可以用于连贯操作，跟着其他的操作
     * @param $sql
     * @return resource
     */
    public function query($sql) {
        if (!$this->connected) {
            $this->connect();
        }
        //$this->r = mysql_query($sql, $this->hdb) or die ('MySQL Error on [RAW] query. ' . mysql_error());
        $this->r = $this->_log_query($sql, $this->hdb); //数据库系统设计综合实验特殊设计
        return $this;
    }

    /**
     * 数据库插入操作，成功返回最后插入ID，失败返回假
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
     * 返回INSERT操作最后插入的自增ID
     * @return int
     */
    public function last_id() {
        if ($this->hdb) {
            return mysql_insert_id($this->hdb);
        }
        return false;
    }

    /**
     * 返回INSERT，UPDATE 或 DELETE 查询所影响的记录行数
     * @return int
     */
    public function affected_rows() {
        if ($this->hdb) {
            return mysql_affected_rows($this->hdb);
        }
        return false;
    }

    /**
     * sql字符串安全转义
     * @param $string
     * @return string
     */
    public function escape($string) {
        return mysql_real_escape_string($string, $this->hdb);
    }

    /**
     * sql执行错误号
     * @return int
     */
    public function errno() {
        if ($this->hdb) {
            return mysql_errno($this->hdb);
        }
        return false;
    }

    /**
     * sql执行错误信息
     * @return string
     */
    public function errmsg() {
        if ($this->hdb) {
            return mysql_error($this->hdb);
        }
        return false;
    }

    /**
     * 关闭数据库连接
     * @return bool
     */
    public function close() {
        if ($this->hdb) {
            mysql_close($this->hdb);
            $this->connected = false;
            $this->hdb = false;
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