<?php
defined('DPPATH') or exit();
/**
 * @package    dp
 * @author    DongHuichun Email:dhc.1229@163.com
 * @link    http://donghuichun.com
 * @version 1.0
 * @copyright    Copyright (c) 2015-05-09.
 */
class template
{

    private $files = array();

    private $fileCachePath = '';

    private $fileCacheName = '';

    private $vars = array();

    private function init()
    {
        $this->setFileCachePath();

        $this->setFileCacheName();
    }

    /**
     *
     */
    private function setFileCachePath()
    {
        $this->fileCachePath = DATA_PATH . '/' . $GLOBALS['DP_module'] . '/tpl';
        DP_mkdir($this->fileCachePath);
    }

    /**
     *
     */
    private function setFileCacheName()
    {
        $this->fileCacheName = $this->fileCachePath . $GLOBALS['DP_controller'] . '_' . $GLOBALS['DP_action'] . '.php';
    }

    /**
     * @param $values
     */
    public function setVars($key, $value)
    {
        $this->vars[$key] = $value;
    }

    /**
     * @param $file head/head.html head.html
     */
    public function setFiles($file)
    {
        $this->files[] = $file;
    }


    public function out()
    {
        $this->init();
        $html = '';
        if (!$this->files) {
            echo '';
            exit;
        }

        foreach($this->files as $k => $v) {
            $varr = explode('/', $v);
            if ($varr[0] && !$varr[1]) {
                $filepath = '';
                $filename = $varr[0];
            }
            else {
                $filepath = $varr[0];
                $filename = $varr[1];
            }
            $filename = $filename . TPL_SUFFIX;
            $file = APP_PATH . $GLOBALS['DP_module'] . '/views/' . $filepath . '/' . $filename;
            if (!file_exists($file)) {
                $file = LIB_PATH . 'template/views/' . $filepath . '/' . $filename;
                if (!file_exists($file)) {
                    continue;
                }
            }

            $file_html = file_get_contents($file);
            $html .= $file_html;
        }

        $html = str_replace('{MATERIAL_PATH}','http://localhost/dp/lib/template/views/res/',$html);

        DP_file_write($this->fileCacheName, $html);

        $this->run();
    }

    private function run()
    {
        if ($this->vars) {
            foreach($this->vars as $k => $v) {
                $$k = $v;
            }
        }

        ob_clean();
        ob_start();
        include $this->fileCacheName;
        $result = ob_get_contents();
        ob_clean();
        unset($this->vars);
        echo $result;
        exit;

        //echo convert(memory_get_usage()-$GLOBALS['DP_startMemsUse']);
        //exit;
    }



} 