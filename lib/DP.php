<?php
defined('DPPATH') or exit();
/**
 * @package    dp
 * @author    DongHuichun Email:dhc.1229@163.com
 * @link    http://donghuichun.com
 * @version 1.0
 * @copyright    Copyright (c) 2015-05-09.
 */

/**
 * Set the default time zone.
 */
date_default_timezone_set('PRC');

/**
 * Set the default locale.
 */
setlocale(LC_ALL, 'en_US.utf-8');

require_once(LIB_PATH . 'common/common.php');

if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('PRC');
}

    if (dp_check_php_version('5.3.0')) {
        define('MAGIC_QUOTES_GPC', false);
    } else {
        ini_set('magic_quotes_runtime', 0);
        define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc() ? True : False);
    }

if (ini_get('register_globals'))
{
    // Reverse the effects of register_globals
    DP_globals();
}

$safe_mode = (bool) ini_get('safe_mode');


defined('APP_NAME') or define('APP_NAME', basename(dirname($_SERVER['SCRIPT_FILENAME'])));

$config_list = array(
    LIB_PATH . 'config.php',
    CONF_PATH . 'config.php',
);
foreach ($config_list as $key => $file) {
    if (is_file($file)) {
        require($file);
    }
}

$requirelist = array(
    LIB_CORE_PATH,
    LIB_PATH . 'DP_Controller.php',
    LIB_PATH . 'DP_Models.php',
    LIB_PATH . 'common/functions.php',
    LIB_PATH . 'template/lib/template.class.php',
);
foreach ($requirelist as $key => $file) {
        dp_require_class($file);
}



$loadlist = array(
    'Route' => SYS_PATH . 'route/route.php',
);
foreach ($loadlist as $key => $file) {
    if (is_file($file)) {
        $$key = DP_load_class($file, $key);
    }
}

Input::clean_input_data($_REQUEST);



$Route->init($_REQUEST['m'],$_REQUEST['c'],$_REQUEST['a']);
echo DP_get_request_url('vod','vod','index');
$Route->uri();

//dp_halt(2);

//dp_redirect('http://baidu.com',3);











 