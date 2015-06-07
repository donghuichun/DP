<?php
defined('DPPATH') or exit();
/**
 * @package	dp
 * @author	DongHuichun Email:dhc.1229@163.com
 * @link	http://donghuichun.com
 * @version 1.0
 * @copyright	Copyright (c) 2015-05-09.
 */

abstract class DP_Models extends Models
{

    /**
     * Template loading and setup routine.
     */
    public function __construct()
    {
        parent::__construct();


    }

    /**
     * Loads the template [View] object.
     */
    public function __destruct()
    {
        parent::__destruct();
    }



}

