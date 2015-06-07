<?php
defined('DPPATH') or exit();
/**
 * @package    dp
 * @author    DongHuichun Email:dhc.1229@163.com
 * @link    http://donghuichun.com
 * @version 1.0
 * @copyright    Copyright (c) 2015-05-09.
 */

class Route
{
    //http://localhost/dp/index.php?m=vod&c=welcome&a=index
    //http://localhost/dp/vod/welcome/index

    var $route_type = 1;



    public function init($m='',$c='',$a='')
    {
        if (file_exists(CONF_PATH.'route.php'))
        {
            include(CONF_PATH.'route.php');
        }

        if(!isset($route))
        {
            $route = array(

                'route_type' => '1',//1:m=&c=&a=  2:m/c/a

                'default' => array('module' => 'sys', 'controller' => 'index', 'action' => 'index',),

            );
        }

        $this->route_type = $route['route_type'];

        $GLOBALS['DP_controller'] = $c?$c:$route['default']['controller'];
        $GLOBALS['DP_action'] = $a?$a:$route['default']['action'];
        $GLOBALS['DP_module'] = $m?$m:$route['default']['module'];

        $GLOBALS['DP_MODULE_TPL_PATH'] = DATA_PATH.$GLOBALS['DP_module'].'/'.DP_MODULE_TPL.'/';
        $GLOBALS['DP_MODULE_CONFIG_PATH'] = DATA_PATH.$GLOBALS['DP_module'].'/'.DP_MODULE_CONFIG.'/';
        $GLOBALS['DP_MODULE_CACHE_PATH'] = DATA_PATH.$GLOBALS['DP_module'].'/'.DP_MODULE_CACHE.'/';
    }

    public function uri($m='',$c='',$a='')
    {

        if($this->route_type==1)
        {
            $this->uri_1($m,$c,$a);
        }
    }

    private function uri_1($m = '', $c = '', $a = '')
    {
        $m = $m ? $m : $GLOBALS['DP_module'];
        $c = $c ? $c : $GLOBALS['DP_controller'];
        $a = $a ? $a : $GLOBALS['DP_action'];

        if (strrchr($m,'Api') !== false) {
            $file = APP_PATH.$m.'/api/'.$c.'.php';
        }else{
            $file = APP_PATH.$m.'/controllers/'.$c.'.php';
        }

        if(!file_exists($file))
        {
            $this->_404();
        }
        $controller_obj = DP_load_class($file,DP_get_controller_classname($m,$c));

        //验证方法
        $controller_obj->init($GLOBALS['DP_module']);
        return $controller_obj->{$a}();

    }

    private function _404()
    {

    }

    public function get_url($params = array(), $url = '',$isApi=false)
    {
        switch ($this->route_type) {
            case 1:

                $url = ($url ? $url : DP_BASEURL) . 'index.php';
                if (is_array($params) && $params) {
                    if($isApi)
                    {
                        $params['m'] = $params['m']?($params['m'].'Api'):'';
                    }
                    $url = $url . '?' . http_build_query($params);
                }
                break;
        }
        return $url;
    }

}