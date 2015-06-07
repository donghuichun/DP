<?php
defined('DPPATH') or exit();
/**
 * @package	dp
 * @author	DongHuichun Email:dhc.1229@163.com
 * @link	http://donghuichun.com
 * @version 1.0
 * @copyright	Copyright (c) 2015-05-09.
 */
class R
{

    /**
     * @des 请求其他类的方法，可以跨模块
     * @param $m 模块标识
     * @param $c controllername
     * @param $a 方法
     * @return mixed
     */
    public static function request($m, $c, $a,$params=array())
    {

        $request_filename = APP_PATH . $m . '/controllers/' . $c . '.php';

        //判断是否是同服务器上的程序
        $instance = DP_get_instance();
        $module_deploy = $instance->DP_GLOBAL_CONFIG['module_' . $instance->moduleSgin];
        $go_module_deploy = $instance->DP_GLOBAL_CONFIG['module_' . $m];

        if (is_array($module_deploy) && $module_deploy && is_array($go_module_deploy) && $go_module_deploy) {
            if ($module_deploy['host'] != $go_module_deploy['host']) {

                //curl请求
                $params['_fromcurl'] = TRUE;
                $url = DP_get_request_url($m, $c,$a,$params,DP_mk_url($go_module_deploy));
                //$url = $go_module_deploy['host'] . '/' . $go_module_deploy['dir'] . '/' . $go_module_deploy['filename'] . '?m=' . $m . '&c=' . $c . '&a=' . $a . '&_fromcurl=1';
                $result = Curl::request($url);
                return $result;
            }
        }


        $controller_obj = DP_load_class($request_filename, DP_get_controller_classname($m,$c));
        $controller_obj->init($m);

        $result = $controller_obj->$a();

        return $result;
    }

    /**
     * URL重定向
     * @param string $url 重定向的URL地址
     * @param integer $time 重定向的等待时间（秒）
     * @param string $msg 重定向前的提示信息
     * @return void
     */
    function DP_redirect($url, $time = 0, $msg = '')
    {
        //多行URL地址支持
        $url = str_replace(array("\n", "\r"), '', $url);
        if (empty($msg))
            $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
        if (!headers_sent()) {
            // redirect
            if (0 === $time) {
                header('Location: ' . $url);
            } else {
                header("refresh:{$time};url={$url}");
                echo($msg);
            }
            exit();
        } else {
            $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
            if ($time != 0)
                $str .= $msg;
            exit($str);
        }
    }
}
 