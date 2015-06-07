<?php
defined('DPPATH') or exit();
/**
 * @package	dp
 * @author	DongHuichun Email:dhc.1229@163.com
 * @link	http://donghuichun.com
 * @version 1.0
 * @copyright	Copyright (c) 2015-05-09.
 */

class C_vod_vod extends DP_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    function index()
    {

        if($_REQUEST['_fromcurl']){
            echo json_encode(array(1,2,3,4));
        }else{
            //return array(1,2,3);
        }
        $GLOBALS['DP_endTime'] = microtime(TRUE);
        return (memory_get_usage()-$GLOBALS['DP_startMemsUse']);
        //print_r(array(1,2,3));
        //exit;
        //echo $this->DP_GLOBAL_CONFIG['moduleSgin'];
        //DP_request_module('dev','index','index');
        //print_r(($this->DP_GLOBAL_CONFIG['db']));

    }
}
 