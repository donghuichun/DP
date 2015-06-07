<?php
defined('DPPATH') or exit();
/**
 * @package	dp
 * @author	DongHuichun Email:dhc.1229@163.com
 * @link	http://donghuichun.com
 * @version 1.0
 * @copyright	Copyright (c) 2015-05-09.
 */

class C_dev_index extends DP_Controller
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
        //echo 444;
        echo $this->DP_GLOBAL_CONFIG['moduleSgin'];
        //DP_request_module('dev','index','index');
        //print_r(($this->DP_GLOBAL_CONFIG['db']));

    }
}




 