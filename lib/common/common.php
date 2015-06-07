<?php

/**
 * @package    dp
 * @author    DongHuichun Email:dhc.1229@163.com
 * @link    http://donghuichun.com
 * @version 1.0
 * @copyright    Copyright (c) 2015-05-09.
 */

if ( ! function_exists('remove_invisible_characters'))
{
    function remove_invisible_characters($str, $url_encoded = TRUE)
    {
        $non_displayables = array();

        // every control character except newline (dec 10)
        // carriage return (dec 13), and horizontal tab (dec 09)

        if ($url_encoded)
        {
            $non_displayables[] = '/%0[0-8bcef]/';	// url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/';	// url encoded 16-31
        }

        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

        do
        {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        }
        while ($count);

        return $str;
    }
}

function DP_get_instance()
{
    return DP_Controller::$instance;
}

function DP_check_php_version($version = '5.3.0')
{
    return version_compare(PHP_VERSION, $version) > 0 ? TRUE : FALSE;
}

function &DP_require_class($file)
{
    if (is_dir($file)) {
        $dp = dir($file);
        while ($filename = $dp->read()) {
            if ($filename != "." && $filename != "..") {
                DP_require_class($file . "/" . $filename);
            }
        }
        $dp->close();
    } else if (file_exists($file)) {

        static $DP_requireFiles = array();
        if (isset($DP_requireFiles[$file])) {
            return $DP_requireFiles[$file];
        }
        require($file);
        $DP_requireFiles[$file] = true;
    } else {
        $DP_requireFiles[$file] = false;
    }
    return $DP_requireFiles[$file];
}

function &DP_load_class($file, $classname)
{
    static $DP_loadFiles = array();
    if (isset($DP_loadFiles[$classname])) {
        return $DP_loadFiles[$classname];
    }

    if (file_exists($file)) {
        require($file);
        $DP_loadFiles[$classname] = new $classname();

    } else {
        $DP_loadFiles[$classname] = false;
    }
    return $DP_loadFiles[$classname];
}



function DP_mk_module_config($module)
{
    /**
     * if(!is_array($module))
     * {
     * $modulearr[] = $module;
     * $module = $modulearr;
     * }
     */
}

function DP_get_controller_classname($m, $c)
{
    return DP_APPS_CONTROLLER_PREFIX.'_' . ($m) . '_' . ($c);
}

function DP_get_lib_classname($m, $c)
{
    return DP_APPS_LIB_PREFIX.'_' . ($m) . '_' . ($c);
}

function DP_get_module_classname($m, $c)
{
    return DP_APPS_MODEL_PREFIX.'_' . ($m) . '_' . ($c);
}

function DP_get_request_url($m, $c,$a,$params=array(),$url='')
{
    global $DP_GLOBAL_CONFIG;
    $Route = DP_load_class(SYS_PATH . 'route/route.php','Route');
    $params['m'] = $m;
    $params['c'] = $c;
    $params['a'] = $a;
    $url = $Route->get_url($params,$url?$url:DP_mk_url($DP_GLOBAL_CONFIG['module_'.$m]));
    return $url;
}

