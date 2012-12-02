<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-11-21
 * Time: 下午3:28
 * To change this template use File | Settings | File Templates.
 */
class Database {
    private $hdb; //数据库句柄
    private $r; //查询结果

    /**
     * 连接数据库
     * @param $host
     * @param $user
     * @param $pass
     * @param $dbname
     * @param string $charset
     * @return bool
     */
    public function connect($host, $user, $pass, $dbname, $charset = 'UTF8') {
        $this->hdb = mysql_connect($host, $user, $pass) or die('Unable to connect to database!');
        mysql_query('SET NAMES ' . $charset, $this->hdb) or die ('MySQL Error on [SET CHARSET] query. ' . mysql_error());
        return mysql_select_db($dbname, $this->hdb) or die ('MySQL Error on [SET DB] query. ' . mysql_error());
    }

    /**
     * 记录集中记录计数
     * @param $sql
     * @return int
     */
    public function count($sql) {
        $this->r = $this->query($sql);
        return mysql_num_rows($this->r);
    }

    /**
     * 获取记录集中的一行的关联数组
     * @param $sql
     * @return array
     */
    public function fetch($sql) {
        static $sql_hash;

        if ($sql_hash != md5($sql)) {
            //一次新的查询
            $this->query($sql);
            $sql_hash = md5($sql);
        }

        return mysql_fetch_assoc($this->r);
    }

    /**
     * MySQL Raw查询
     * @param $sql
     * @return resource
     */
    public function query($sql) {
        //$this->r = mysql_query($sql, $this->hdb) or die ('MySQL Error on [RAW] query. ' . mysql_error());
        $this->r = $this->_log_query($sql, $this->hdb); //数据库系统设计综合实验特殊设计
        return $this->r;
    }

    /**
     * 返回INSERT操作最后插入的自增ID
     * @return int
     */
    public function last_id() {
        return mysql_insert_id($this->hdb);
    }

    /**
     * 返回INSERT，UPDATE 或 DELETE 查询所影响的记录行数
     * @return int
     */
    public function affected_rows() {
        return mysql_affected_rows($this->hdb);
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
        return mysql_errno($this->hdb);
    }

    /**
     * sql执行错误信息
     * @return string
     */
    public function errmsg() {
        return mysql_error($this->hdb);
    }

    /**
     * 关闭数据库连接
     * @return bool
     */
    public function close() {
        return mysql_close($this->hdb);
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