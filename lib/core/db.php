<?php
defined('DPPATH') or exit();
/**
 * @package	dp
 * @author	DongHuichun Email:dhc.1229@163.com
 * @link	http://donghuichun.com
 * @version 1.0
 * @copyright	Copyright (c) 2015-05-09.
 */
class db
{
    var $dbType = 'mysql';
    var $querynum   = 0;
    var $link;
    var $histories;
    var $host;
    var $user;
    var $password;
    var $dbname;
    var $charset;
    var $pconnect;
    var $tablepre;
    var $time;
    var $goneaway   = 5;
    var $mErrorExit = true;

    function connect($dbConfig)
    {
        if(!$dbConfig)
        {

        }
        $this->host    = $dbConfig['host'];
        $this->user    = $dbConfig['user'];
        $this->password      = $dbConfig['password'];
        $this->dbname    = $dbConfig['dbname'];
        $this->charset = $dbConfig['charset'];
        $this->pconnect  = $dbConfig['pconnect'];
        $this->tablepre  = $dbConfig['tablepre'];
        $this->time      = $dbConfig['time'];

        if ($this->pconnect)
        {
            if (!$this->link = mysql_pconnect($this->host, $this->user, $this->password))
            {
                $this->halt('Can not connect to MySQL server');
            }
        }
        else
        {
            if (!$this->link = mysql_connect($this->host, $this->user, $this->password))
            {
                $this->halt('Can not connect to MySQL server');
            }
        }

        if ($this->version() > '4.1')
        {
            if ($this->charset)
            {
                mysql_query("SET character_set_connection=" . $this->charset . ", character_set_results=" . $this->charset . ", character_set_client=binary", $this->link);
            }

            if ($this->version() > '5.0.1')
            {
                @mysql_query("SET sql_mode=''", $this->link); //关闭严格模式
            }
        }

        if ($this->dbname)
        {
            mysql_select_db($this->dbname, $this->link);
        }
    }

    function version()
    {
        return mysql_get_server_info($this->link);
    }
}

 