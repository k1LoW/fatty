<?php
  /**
   * Fatty: Simple Git repogitory browser plugin for CakePHP.
   *
   */
  /**
   * SvnComponent code license:
   *
   * @copyright   Copyright (C) 2010 by 101000code/101000LAB
   * @since       CakePHP(tm) v 1.2
   * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
   */
class SvnComponent extends Object {

    var $settings = array();
    var $enebled = true;
    var $controller;

    /**
     * initialize
     *
     */
    function initialize(&$controller, $settings){
        if (defined('FATTY_SVN_PATH')) {
            Configure::write('Fatty.svn_path', FATTY_SVN_PATH);
        } else {
            if (!Configure::read('Fatty.svn_path')) {
                Configure::write('Fatty.svn_path', '/usr/bin/svn');
            }
        }
    }

    /**
     * startup
     *
     */
    function startup(&$controller){
    }

    /**
     * beforeRender
     *
     * @return
     */
    function beforeRender(&$controller){
    }

    /**
     * log
     * svn log
     *
     * @return
     */
    function log($limit = 20, $offset = 0, $filepath = null){
        $root = ROOT;
        $cmd = 'cd ' . $root . ';' . Configure::read('Fatty.svn_path') . " log -r HEAD:1 --limit " . $limit . ' ' . $root . ' 2>&1';
        putenv("HOME=/var/www/html");
        putenv("LANG=ja_JP.UTF-8");
        $out = $this->_exec($cmd);
        $logs = array();
        foreach ($out as $line) {
            if (preg_match('/^r([0-9]+) \| ([^|]+) \| ([^|]+) \|.+$/', $line, $matches)) {
                $rev = $matches[1];
                $logs[$rev] = array();
                $logs[$rev]['rev'] = $rev;
                $logs[$rev]['Author'] = $matches[2];
                $logs[$rev]['Date'] = $matches[3];
                $logs[$rev]['comment'] = '';
            }
            if (preg_match('/^[^-r]/', $line)) {
                if (isset($rev)) {
                    $logs[$rev]['comment'] = $line . "\n";
                }
            }
        }
        return $logs;
    }

    /**
     * _exec
     *
     * @param $cmd
     * @return
     */
    function _exec($cmd){
        $out = array();
        exec($cmd, $out);
        return $out;
    }

}
