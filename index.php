<?php

/**
 * @package    dp
 * @author    DongHuichun Email:dhc.1229@163.com
 * @link    http://donghuichun.com
 * @version 1.0
 * @copyright    Copyright (c) 2015-05-09.
 */


defined('DEBUG_MODE') or define('DEBUG_MODE', 'd'); // 模式 d表示调试模式  p正式上线

define('CHARSET','UTF-8');

switch(DEBUG_MODE) {
    case 'd':
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        break;

    case 'p':
        error_reporting(0);
        break;

    default:
        error_reporting(0);
}

//初始时间
$GLOBALS['DP_startTime'] = microtime(TRUE);

//内存初始值
define('MEMORY_USE_ON', function_exists('memory_get_usage'));
if (MEMORY_USE_ON) {
    $GLOBALS['DP_startMemsUse'] = memory_get_usage();
}


$app_path = 'apps';

$conf_path = 'conf';

$data_path = 'data';

$lib_path = 'lib';

$sys_path = 'system';

defined('DPPATH') or define('DPPATH', dirname(__FILE__) . '/');

defined('APP_PATH') or define('APP_PATH', DPPATH . $app_path . '/');

defined('CONF_PATH') or define('CONF_PATH', DPPATH . $conf_path . '/');

defined('DATA_PATH') or define('DATA_PATH', DPPATH . $data_path . '/');

defined('LIB_PATH') or define('LIB_PATH', DPPATH . $lib_path . '/');

defined('SYS_PATH') or define('SYS_PATH', DPPATH . $sys_path . '/');

defined('LIB_CORE_PATH') or define('LIB_CORE_PATH', LIB_PATH . 'core/');


define('MEMORY_LIMIT_ON', function_exists('memory_get_usage'));


require_once(LIB_PATH.'DP.php');




