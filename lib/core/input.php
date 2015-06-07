<?php
defined('DPPATH') or exit();
/**
 * @package    dp
 * @author    DongHuichun Email:dhc.1229@163.com
 * @link    http://donghuichun.com
 * @version 1.0
 * @copyright    Copyright (c) 2015-05-09.
 */
class Input
{
    function __construct()
    {

        if (
            preg_match('/./u', 'é') === 1 // PCRE must support UTF-8
            AND function_exists('iconv') // iconv must be installed
            AND ini_get('mbstring.func_overload') != 1 // Multibyte string function overloading cannot be enabled
            AND CHARSET == 'UTF-8' // Application charset must be UTF-8
        ) {
            define('UTF8_ENABLED', TRUE);

            // set internal encoding for multibyte string functions if necessary
            // and set a flag so we don't have to repeatedly use extension_loaded()
            // or function_exists()
            if (extension_loaded('mbstring')) {
                define('MB_ENABLED', TRUE);
                mb_internal_encoding('UTF-8');
            } else {
                define('MB_ENABLED', FALSE);
            }
        } else {
            define('UTF8_ENABLED', FALSE);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Clean UTF-8 strings
     *
     * Ensures strings are UTF-8
     *
     * @access    public
     * @param    string
     * @return    string
     */
    function clean_string($str)
    {
        if (self::_is_ascii($str) === FALSE) {
            $str = @iconv('UTF-8', 'UTF-8//IGNORE', $str);
        }

        return $str;
    }

    // --------------------------------------------------------------------

    /**
     * Remove ASCII control characters
     *
     * Removes all ASCII control characters except horizontal tabs,
     * line feeds, and carriage returns, as all others can cause
     * problems in XML
     *
     * @access    public
     * @param    string
     * @return    string
     */
    function safe_ascii_for_xml($str)
    {
        return remove_invisible_characters($str, FALSE);
    }

    // --------------------------------------------------------------------

    /**
     * Convert to UTF-8
     *
     * Attempts to convert a string to UTF-8
     *
     * @access    public
     * @param    string
     * @param    string - input encoding
     * @return    string
     */
    function convert_to_utf8($str, $encoding)
    {
        if (function_exists('iconv')) {
            $str = @iconv($encoding, 'UTF-8', $str);
        } elseif (function_exists('mb_convert_encoding')) {
            $str = @mb_convert_encoding($str, 'UTF-8', $encoding);
        } else {
            return FALSE;
        }

        return $str;
    }

    // --------------------------------------------------------------------

    /**
     * Is ASCII?
     *
     * Tests if a string is standard 7-bit ASCII or not
     *
     * @access    public
     * @param    string
     * @return    bool
     */
    function _is_ascii($str)
    {
        return (preg_match('/[^\x00-\x7F]/S', $str) == 0);
    }


    function globals()
    {
        if (isset($_REQUEST['GLOBALS']) OR isset($_FILES['GLOBALS'])) {
            exit('Request aborted');
        }

        $global_variables = array_keys($GLOBALS);

        $global_variables = array_diff($global_variables, array(
            '_COOKIE',
            '_ENV',
            '_GET',
            '_FILES',
            '_POST',
            '_REQUEST',
            '_SERVER',
            '_SESSION',
            'GLOBALS',
        ));

        foreach ($global_variables as $name) {
            unset($GLOBALS[$name]);
        }
    }

    /**
     * Clean Input Data
     *
     * This is a helper function. It escapes data and
     * standardizes newline characters to \n
     *
     * @access    private
     * @param    string
     * @return    string
     */
    function clean_input_data($str)
    {

        if (is_array($str) OR is_object($str)) {
            foreach ($str as $key => $val) {
                $str[self::clean_input_keys($key)] = self::clean_input_data($val);
            }
            return $str;
        }
        if (MAGIC_QUOTES_GPC)
        {
            $str = stripslashes($str);
        }

        // Clean UTF-8 if supported
        if (UTF8_ENABLED === TRUE) {
            $str = self::clean_string($str);
        }

        // Remove control characters
        $str = remove_invisible_characters($str);

        // Should we filter the input data?
        /**
         * if ($this->_enable_xss === TRUE) {
         * $str = $this->xss_clean($str);
         * }
         */

        return $str;
    }

// --------------------------------------------------------------------

    /**
     * Clean Keys
     *
     * This is a helper function. To prevent malicious users
     * from trying to exploit keys we make sure that keys are
     * only named with alpha-numeric text and a few other items.
     *
     * @access    private
     * @param    string
     * @return    string
     */
    function clean_input_keys($str)
    {
        if (!preg_match("/^[a-z0-9:_\/-]+$/i", $str)) {
            exit('Disallowed Key Characters.');
        }

        // Clean UTF-8 if supported
        if (UTF8_ENABLED === TRUE) {
            $str = self::clean_string($str);
        }

        return $str;
    }
}
 