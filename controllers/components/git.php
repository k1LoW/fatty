<?php
  /**
   * Fatty: Simple Git repogitory browser plugin for CakePHP.
   *
   */
  /**
   * GitComponent code license:
   *
   * @copyright   Copyright (C) 2010 by 101000code/101000LAB
   * @since       CakePHP(tm) v 1.2
   * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
   */
class GitComponent extends Object {

    var $settings = array();
    var $enebled = true;
    var $controller;
    var $currentBranch = null;
    var $branches = array();

    /**
     * initialize
     *
     */
    function initialize(&$controller, $settings){
        if (Configure::read('debug') < 2 && empty($this->settings['forceEnable'])) {
            $this->enabled = false;
            return false;
        }
        if (defined('FATTY_GIT_PATH')) {
            Configure::write('Fatty.git_path', FATTY_GIT_PATH);
        } else {
            if (!Configure::read('Fatty.git_path')) {
                Configure::write('Fatty.git_path', '/usr/bin/git');
            }
        }
        if (defined('FATTY_GIT_DIR')) {
            Configure::write('Fatty.git_dir', FATTY_GIT_DIR);
        } else {
            if (!Configure::read('Fatty.git_dir')) {
                Configure::write('Fatty.git_dir', ROOT . DS . '.git' . DS);
            }
        }
        if (defined('FATTY_LOG_LIMIT')) {
            Configure::write('Fatty.log_limit', FATTY_LOG_LIMIT);
        } else {
            if (!Configure::read('Fatty.log_limit')) {
                Configure::write('Fatty.log_limit', 20);
            }
        }
    }

    /**
     * startup
     *
     */
    function startup(&$controller){
        $controller->helpers['Fatty.Tip'] = array(
                                                  'forceEnable' => isset($this->settings['forceEnable'])? true : null,
                                                  );
        $this->branch();
    }

    /**
     * beforeRender
     *
     * @return
     */
    function beforeRender(&$controller){
        $controller->set('fattyBranch', $this->currentBranch);
    }

    /**
     * branch
     * git branch
     *
     * @param
     * @return
     */
    function branch(){
        $cmd = 'GIT_DIR=' . Configure::read('Fatty.git_dir') . " " . Configure::read('Fatty.git_path') . " branch";
        $out = $this->_exec($cmd);
        $this->branches = array();
        foreach ($out as $value) {
            $this->branches[] = $value;
            if (preg_match('/^\* *([^ ]+)/', $value, $matches)) {
                $this->currentBranch = $matches[1];
            }
        }
    }

    /**
     * count
     * git log count
     *
     * @param
     * @return
     */
    function count($filepath = null){
        if ($filepath) {
            $root = preg_replace('/\.git\/*/', '', Configure::read('Fatty.git_dir'));
            $cmd = 'cd ' . $root . ';GIT_DIR=' . Configure::read('Fatty.git_dir') . " " . Configure::read('Fatty.git_path') . " log --pretty=oneline " . $root . $filepath . " | wc -l";
        } else {
            $cmd = 'GIT_DIR=' . Configure::read('Fatty.git_dir') . " " . Configure::read('Fatty.git_path') . " log --pretty=oneline | wc -l";
        }

        $out = $this->_exec($cmd);
        return $out[0];
    }

    /**
     * log
     * git log
     *
     * @param
     * @return
     */
    function log($limit = 20, $offset = 0, $filepath = null){
        if ($filepath) {
            $root = preg_replace('/\.git\/*/', '', Configure::read('Fatty.git_dir'));
            $cmd = 'cd ' . $root . ';GIT_DIR=' . Configure::read('Fatty.git_dir') . " " . Configure::read('Fatty.git_path') . " log --stat -n " . $limit . " --skip=" . $offset . " --parents " . $root . $filepath;
        } else {
            $cmd = 'GIT_DIR=' . Configure::read('Fatty.git_dir') . " " . Configure::read('Fatty.git_path') . " log --stat -n " . $limit . " --skip=" . $offset . " --parents";
        }

        $out = $this->_exec($cmd);

        $logs = array();
        foreach ($out as $line) {
            if (preg_match('/^commit ([\w]+) *([\w]*) *([\w]*)/',$line,$matches)) {
                $hash = $matches[1];
                $parent = $matches[2];
                $parent2 = $matches[3];
                $logs[$hash]['hash'] = $hash;
                $logs[$hash]['parent'] = $parent;
                $logs[$hash]['parent2'] = $parent2;
            }
            if (preg_match('/Author: ([\w]+)/',$line,$matches)) {
                $logs[$hash]['Author'] = $matches[1];
            }
            if (preg_match('/Date:[ ]*(.+)$/',$line,$matches)) {
                $logs[$hash]['Date'] = $matches[1];
            }
            if (preg_match('/^[ ]{4}(.+)$/',$line,$matches)) {
                if (empty($logs[$hash]['comment'])) {
                    $logs[$hash]['comment'] = '';
                }
                $logs[$hash]['comment'] .= $matches[1] . "\n";
            }
            if (preg_match('/^[ ]([\w\/.]+)[ ]*\|[ ]*(.+)$/',$line,$matches)) {
                if (empty($logs[$hash]['files'])) {
                    $logs[$hash]['files'] = array();
                }
                $logs[$hash]['files'][] = array('file' => $matches[1],
                                                'change' => $matches[2]);
            }
            if (preg_match('/^[ ][\d]+ files.+/',$line,$matches)) {
                $logs[$hash]['change'] = $matches[0];
            }
        }
        return $logs;
    }

    /**
     * show
     * git show
     *
     * @param $hash
     * @return
     */
    function show($hash){
        $cmd = 'GIT_DIR=' . Configure::read('Fatty.git_dir') . " " . Configure::read('Fatty.git_path') . " show " . $hash . " --parents";
        $out = $this->_exec($cmd);
        $commit = array();
        $commit['comment'] = '';
        $commit['diff'] = array();
        $author = false;
        $date = false;
        $diff = false;
        $file = '';
        $part = 0;

        foreach ($out as $line) {
            if (preg_match('/^commit ([\w]+) *([\w]*) *([\w]*)/',$line,$matches)) {
                $hash = $matches[1];
                $parent = $matches[2];
                $parent2 = $matches[3];
                $commit['hash'] = $hash;
                $commit['parent'] = $parent;
                $commit['parent2'] = $parent2;
                continue;
            }
            if (preg_match('/Author: ([\w]+)/',$line,$matches) && !$author) {
                $author = true;
                $commit['Author'] = $matches[1];
                continue;
            }
            if (preg_match('/Date:[ ]*(.+)$/',$line,$matches) && !$date) {
                $date = true;
                $commit['Date'] = $matches[1];
                continue;
            }
            if (preg_match('/^[ ]{4}(.+)$/',$line,$matches) && !$diff) {
                $commit['comment'] .= $matches[1] . "\n";
                continue;
            }
            if (preg_match('/^diff --git a\/([^\s]+)/',$line,$matches)) {
                $diff = true;
                $file = $matches[1];
                $commit['diff'][$file] = array();
                continue;
            }
            if (preg_match('/^diff --cc ([^\s]+)/',$line,$matches)) {
                $diff = true;
                $file = $matches[1];
                $commit['diff'][$file] = array();
                continue;
            }
            if ($diff && $file && !preg_match('/^diff|^index|^\+\+\+|^---/',$line)) {
                if (preg_match('/^@@ -(\d+),?(\d*) \+(\d+),?(\d*) @@/',$line)) {
                    $part++;
                    $commit['diff'][$file][$part] = array();
                }

                $commit['diff'][$file][$part][] = $line;
            }
        }
        return $commit;
    }

    /**
     * diff
     *
     * @param $a
     * @param $b
     * @return
     */
    function diff($a = 'HEAD', $b = 'HEAD'){
        $cmd = 'GIT_DIR=' . Configure::read('Fatty.git_dir') . " " . Configure::read('Fatty.git_path') . " diff " . $a . " " . $b;
        $out = $this->_exec($cmd);
        $commit = array();
        $commit['diff'] = array();
        $diff = false;
        $file = '';
        $part = 0;
        foreach ($out as $line) {
            if (preg_match('/^diff --git a\/([\w\/.]+)/',$line,$matches)) {
                $diff = true;
                $file = $matches[1];
                $commit['diff'][$file] = array();
            }
            if ($diff && $file && !preg_match('/^diff|^index|^\+\+\+|^---/',$line)) {
                if (preg_match('/^@@ -(\d+),(\d+) \+(\d+),(\d+) @@/',$line)) {
                    $part++;
                    $commit['diff'][$file][$part] = array();
                }

                $commit['diff'][$file][$part][] = $line;
            }
        }
        return $commit;
    }

    /**
     * blame
     *
     * @param $filepath
     * @return
     */
    function blame($filepath){
        $root = preg_replace('/\.git\/*/', '', Configure::read('Fatty.git_dir'));
        $cmd = 'cd ' . $root . ';' . Configure::read('Fatty.git_path') . " blame -l" . " " . $root . $filepath;
        $out = $this->_exec($cmd);
        //pr($out);
        $blame = array();
        foreach ($out as $line) {
            if (preg_match('/^([0-9a-z^]+) \(([^ \)]+) +([^\)]+) +([\d]+)\) (.+)$/',$line,$matches)) {
                $blame[] = array('hash' => $matches[1],
                                 'commiter' => $matches[2],
                                 'date' => $matches[3],
                                 'line' => $matches[4],
                                 'code' => $matches[5]);
            }
        }
        return $blame;
    }

    /**
     * tree
     * ls-tree
     *
     * @param $hash
     * @return
     */
    function tree($hash = 'HEAD'){
        $root = preg_replace('/\.git\/*/', '', Configure::read('Fatty.git_dir'));
        $cmd = 'cd ' . $root . ';' . Configure::read('Fatty.git_path') . " ls-tree " . $hash;
        $out = $this->_exec($cmd);
        $tree = array();
        foreach ($out as $file) {
            if (preg_match('/^[0-9]+ ([a-z]+) ([0-9a-z]+)\s(.+)/',$file,$matches)) {
                $tree[] = array('type' => $matches[1],
                                'hash' => $matches[2],
                                'name' => $matches[3]);
            }
        }
        return $tree;
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
