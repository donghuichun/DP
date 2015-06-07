<?php
defined('DPPATH') or exit();
/**
 * @package	dp
 * @author	DongHuichun Email:dhc.1229@163.com
 * @link	http://donghuichun.com
 * @version 1.0
 * @copyright	Copyright (c) 2015-05-09.
 */

class C_sys_sys extends DP_Controller
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
        $this->tpl->setVars('dong','');
        $this->tpl->setFiles('head/index');
        $this->tpl->setFiles('body');
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
 