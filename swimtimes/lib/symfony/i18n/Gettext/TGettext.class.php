<?php
/**
 * TGettext class file.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the BSD License.
 *
 * Copyright(c) 2004 by Qiang Xue. All rights reserved.
 *
 * To contact the author write to {@link mailto:qiang.xue@gmail.com Qiang Xue}
 * The latest version of PRADO can be obtained from:
 * {@link http://prado.sourceforge.net/}
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Revision: 1415 $  $Date: 2006-06-11 10:33:51 +0200 (Sun, 11 Jun 2006) $
 * @package System.I18N.core
 */

// +----------------------------------------------------------------------+
// | PEAR :: File :: Gettext                                              |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is available at http://www.php.net/license/3_0.txt              |
// | If you did not receive a copy of the PHP license and are unable      |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 Michael Wallner <mike@iworks.at>                  |
// +----------------------------------------------------------------------+
//
// $Id: TGettext.class.php 1415 2006-06-11 08:33:51Z fabien $

/**
 * File::Gettext
 * 
 * @author      Michael Wallner <mike@php.net>
 * @license     PHP License
 */

/**
 * Use PHPs builtin error messages
 */
//ini_set('track_errors', true);

/** 
 * File_Gettext
 * 
 * GNU gettext file reader and writer.
 * 
 * #################################################################
 * # All protected members of this class are public in its childs. #
 * #################################################################
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision: 1415 $
 * @access      public
 * @package System.I18N.core 
 */
class TGettext
{
    /**
     * strings
     * 
     * associative array with all [msgid => msgstr] entries
     * 
     * @access  protected
     * @var     array
    */
    protected $strings = array();

    /**
     * meta
     * 
     * associative array containing meta 
     * information like project name or content type
     * 
     * @access  protected
     * @var     array
     */
    protected $meta = array();
    
    /**
     * file path
     * 
     * @access  protected
     * @var     string
     */
    protected $file = '';
    
    /**
     * Factory
     *
     * @static
     * @access  public
     * @return  object  Returns File_Gettext_PO or File_Gettext_MO on success 
     *                  or PEAR_Error on failure.
     * @param   string  $format MO or PO
     * @param   string  $file   path to GNU gettext file
     */
    function factory($format, $file = '')
    {
        $format = strToUpper($format);
        $filename = dirname(__FILE__).'/'.$format.'.php';
        if(is_file($filename) == false)
        	throw new Exception ("Class file $file not found");
        	
        include_once $filename;
        $class = 'TGettext_' . $format;

        return new $class($file);
    }

    /**
     * poFile2moFile
     *
     * That's a simple fake of the 'msgfmt' console command.  It reads the
     * contents of a GNU PO file and saves them to a GNU MO file.
     * 
     * @static
     * @access  public
     * @return  mixed   Returns true on success or PEAR_Error on failure.
     * @param   string  $pofile path to GNU PO file
     * @param   string  $mofile path to GNU MO file
     */
    function poFile2moFile($pofile, $mofile)
    {
        if (!is_file($pofile)) {
            throw new Exception("File $pofile doesn't exist.");
        }
        
        include_once dirname(__FILE__).'/PO.php';
        
        $PO = new TGettext_PO($pofile);
        if (true !== ($e = $PO->load())) {
            return $e;
        }
        
        $MO = $PO->toMO();
        if (true !== ($e = $MO->save($mofile))) {
            return $e;
        }
        unset($PO, $MO);
        
        return true;
    }
    
    /**
     * prepare
     *
     * @static
     * @access  protected
     * @return  string
     * @param   string  $string
     * @param   bool    $reverse
     */
    function prepare($string, $reverse = false)
    {
        if ($reverse) {
            $smap = array('"', "\n", "\t", "\r");
            $rmap = array('\"', '\\n"' . "\n" . '"', '\\t', '\\r');
            return (string) str_replace($smap, $rmap, $string);
        } else {
        	$string = preg_replace('/"\s+"/', '', $string);
            $smap = array('\\n', '\\r', '\\t', '\"');
            $rmap = array("\n", "\r", "\t", '"');
            return (string) str_replace($smap, $rmap, $string);
        }
    }
    
    /**
     * meta2array
     *
     * @static
     * @access  public
     * @return  array
     * @param   string  $meta
     */
    function meta2array($meta)
    {
        $array = array();
        foreach (explode("\n", $meta) as $info) {
            if ($info = trim($info)) {
                list($key, $value) = explode(':', $info, 2);
                $array[trim($key)] = trim($value);
            }
        }
        return $array;
    }

    /**
     * toArray
     * 
     * Returns meta info and strings as an array of a structure like that:
     * <code>
     *   array(
     *       'meta' => array(
     *           'Content-Type'      => 'text/plain; charset=iso-8859-1',
     *           'Last-Translator'   => 'Michael Wallner <mike@iworks.at>',
     *           'PO-Revision-Date'  => '2004-07-21 17:03+0200',
     *           'Language-Team'     => 'German <mail@example.com>',
     *       ),
     *       'strings' => array(
     *           'All rights reserved'   => 'Alle Rechte vorbehalten',
     *           'Welcome'               => 'Willkommen',
     *           // ...
     *       )
     *   )
     * </code>
     * 
     * @see     fromArray()
     * @access  protected
     * @return  array
     */
    function toArray()
    {
    	return array('meta' => $this->meta, 'strings' => $this->strings);
    }
    
    /**
     * fromArray
     * 
     * Assigns meta info and strings from an array of a structure like that:
     * <code>
     *   array(
     *       'meta' => array(
     *           'Content-Type'      => 'text/plain; charset=iso-8859-1',
     *           'Last-Translator'   => 'Michael Wallner <mike@iworks.at>',
     *           'PO-Revision-Date'  => date('Y-m-d H:iO'),
     *           'Language-Team'     => 'German <mail@example.com>',
     *       ),
     *       'strings' => array(
     *           'All rights reserved'   => 'Alle Rechte vorbehalten',
     *           'Welcome'               => 'Willkommen',
     *           // ...
     *       )
     *   )
     * </code>
     * 
     * @see     toArray()
     * @access  protected
     * @return  bool
     * @param   array       $array
     */
    function fromArray($array)
    {
    	if (!array_key_exists('strings', $array)) {
    	    if (count($array) != 2) {
                return false;
    	    } else {
    	        list($this->meta, $this->strings) = $array;
            }
    	} else {
            $this->meta = @$array['meta'];
            $this->strings = @$array['strings'];
        }
        return true;
    }
    
    /**
     * toMO
     *
     * @access  protected
     * @return  object  File_Gettext_MO
     */
    function toMO()
    {
        include_once dirname(__FILE__).'/MO.php';
        $MO = new TGettext_MO;
        $MO->fromArray($this->toArray());
        return $MO;
    }
    
    /**
     * toPO
     *
     * @access  protected
     * @return  object      File_Gettext_PO
     */
    function toPO()
    {
        include_once dirname(__FILE__).'/PO.php';
        $PO = new TGettext_PO;
        $PO->fromArray($this->toArray());
        return $PO;
    }
}