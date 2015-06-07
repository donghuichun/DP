<?php

/**
 * @package	dp
 * @author	DongHuichun Email:dhc.1229@163.com
 * @link	http://donghuichun.com
 * @version 1.0
 * @copyright	Copyright (c) 2015-05-09.
 */

function DP_halt($error)
{
    echo $error;
    exit;
}

/**
 * 写文件
 *
 * @return intager 写入数据的字节数
 */
function DP_file_write($filename, $content, $mode = 'rb+')
{
    $length = strlen($content);
    @touch($filename);
    if (!is_writeable($filename))
    {
        @chmod($filename, 0666);
    }

    if (($fp = @fopen($filename, $mode)) === false)
    {
        DP_halt('file_write() failed to open stream: ' . $filename . 'Permission denied', E_USER_WARNING);
    }

    flock($fp, LOCK_EX | LOCK_NB);

    $bytes = 0;
    if (($bytes = @fwrite($fp, $content)) === false)
    {
        DP_halt('file_write() Failed to write '.$length.' bytes to '.$filename);
    }

    if ($mode == 'rb+')
    {
        @ftruncate($fp, $length);
    }

    @fclose($fp);

    // 检查是否写入了所有的数据
    if ($bytes != $length)
    {
        DP_halt('file_write() Only '.$bytes.' of '.$length.' bytes written, possibly out of free disk space.');
    }

    // 返回长度
    return $bytes;
}

/**
 * 创建目录函数
 *
 * @param $dir 需要创建的目录
 */
function DP_mkdir($dir)
{
    if (!is_dir($dir))
    {
        if(!@mkdir($dir, CREATE_DIR_MODE, 1))
        {
            return false;//创建目录失败
        }
    }
    return true;
}

/**
 * @param $size
 * @return string
 */
function convert($size)
{
    $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

function DP_mk_url($arr=array())
{
    return $arr['host'].'/'.$arr['dir'].'/'.$arr['filepath'].'/'.$arr['filename'];
}

 