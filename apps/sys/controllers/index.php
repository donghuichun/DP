<?php
defined('DPPATH') or exit();
/**
 * @package	dp
 * @author	DongHuichun Email:dhc.1229@163.com
 * @link	http://donghuichun.com
 * @version 1.0
 * @copyright	Copyright (c) 2015-05-09.
 */

$GLOBALS['DP_DB_NO_CONNECT'] = false;
class C_sys_index extends DP_Controller
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
        //echo $this->DP_GLOBAL_CONFIG['moduleSgin'];
        //print_r($this->DP_GLOBAL_CONFIG['db']);
        //print_r(R::request('vod','vod','index'));
        //echo $this->DP_GLOBAL_CONFIG['moduleSgin'];
        //print_r(DP_request_module('vod','vod','index'));
        exit;

        $this->tpl->setVars('dong','');
        $this->tpl->setFiles('head/index');
        $this->tpl->setFiles('body/index');
        $this->tpl->setFiles('foot/index');
        $this->tpl->out();
    }

    function body()
    {
        $this->tpl->setVars('dong','');
        $this->tpl->setFiles('body');
        $this->tpl->out();
    }
}

 