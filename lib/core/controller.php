<?php
defined('DPPATH') or exit();
/**
 * @package	dp
 * @author	DongHuichun Email:dhc.1229@163.com
 * @link	http://donghuichun.com
 * @version 1.0
 * @copyright	Copyright (c) 2015-05-09.
 */
abstract class Controller extends Base
{
    /**
     * @var
     */
    public $DP_GLOBAL_CONFIG;

    public $moduleSgin;

    public static $instance;

    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    public function init($moduleSgin)
    {
        $this->setModuleSign($moduleSgin);
        $this->setConfig();
    }

    public function setModuleSign($moduleSgin)
    {
        $this->moduleSgin = $moduleSgin;
    }

    public function setConfig()
    {
        if($this->moduleSgin)
        {
            global $DP_GLOBAL_CONFIG;

            @require(DATA_PATH.$this->moduleSgin . '/config/config.php');
            $DP_MODULE_GLOBAL_CONFIG = is_array($DP_MODULE_GLOBAL_CONFIG)?$DP_MODULE_GLOBAL_CONFIG:array();
            $this->DP_GLOBAL_CONFIG = $DP_MODULE_GLOBAL_CONFIG + $DP_GLOBAL_CONFIG;


            //数据库实例 数据库配置 $this->DP_GLOBAL_CONFIG['db']
            if($GLOBALS['DP_DB_NO_CONNECT']!==false)
            {
                $this->DP_GLOBAL_CONFIG['db'];
                $this->db = new db($this->DP_GLOBAL_CONFIG['db']);
            }
            unset($GLOBALS['DP_DB_NO_CONNECT']);
        }

        self::$instance = $this;
    }

    public static function get_instance()
    {
        return self::$instance;
    }

}

