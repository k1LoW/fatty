<?php
  /**
   * Fatty: Simple Git repogitory browser plugin for CakePHP.
   *
   */
  /**
   * FattyController code license:
   *
   * @copyright   Copyright (C) 2010 by 101000code/101000LAB
   * @since       CakePHP(tm) v 1.2
   * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
   */
class FattyController extends FattyAppController {

    var $name = 'Fatty';
    var $uses = array();
    var $helpers = array('Html');
    var $components = array('Fatty.Git', 'Fatty.Svn');

    /**
     * index
     *
     */
    function index($page = 1){
        $limit = Configure::read('Fatty.log_limit');
        $skip = $limit * ($page - 1);

        $count = $this->Git->count();
        $logs = $this->Git->log($limit, $skip);
        $branch = $this->Git->currentBranch;

        $prev = ($page > 1) ? $page - 1 : null;
        $next = ($count/$limit < $page) ? null : $page + 1;

        $this->set(array('limit' => $limit,
                         'count' =>  $count,
                         'branch' =>  $branch,
                         'page' =>  $page,
                         'prev' =>  $prev,
                         'next' =>  $next,
                         ));

        $this->set(compact('logs'));
    }

    /**
     * commit_logs
     * description
     *
     * @param $page
     * @return
     */
    function commit_logs($page = null, $filepath = null){
        $this->layout = 'ajax';
        Configure::write('debug', 0);

        $filepath = base64_decode($filepath);
        $limit = Configure::read('Fatty.log_limit');
        $skip = $limit * ($page - 1);

        $count = $this->Git->count($filepath);
        $logs = $this->Git->log($limit, $skip, $filepath);

        $prev = ($page > 1) ? $page - 1 : null;
        $next = ($count/$limit < $page) ? null : $page + 1;

        $this->set(array(
                         'filepath' => $filepath,
                         'limit' => $limit,
                         'count' =>  $count,
                         'page' =>  $page,
                         'prev' =>  $prev,
                         'next' =>  $next,
                         ));

        $this->set(compact('logs'));
    }

    /**
     * commit
     * show commit
     *
     * @param $hash
     * @return
     */
    function commit($hash){
        $commit = $this->Git->show($hash);
        $this->set(compact('commit'));
    }

    /**
     * commits
     * show file commits
     *
     * @param $filepath
     * @return
     */
    function commits($filepath = null, $page = 1){
        $filepath = base64_decode($filepath);
        $limit = Configure::read('Fatty.log_limit');
        $skip = $limit * ($page - 1);

        $count = $this->Git->count($filepath);
        $logs = $this->Git->log($limit, $skip, $filepath);
        $branch = $this->Git->currentBranch;

        $prev = ($page > 1) ? $page - 1 : null;
        $next = ($count/$limit < $page) ? null : $page + 1;

        $this->set(array(
                         'filepath' => $filepath,
                         'limit' => $limit,
                         'count' =>  $count,
                         'branch' =>  $branch,
                         'page' =>  $page,
                         'prev' =>  $prev,
                         'next' =>  $next,
                         ));

        $this->set(compact('logs'));
    }

    /**
     * diff
     * diff
     *
     * @param $a, $b
     * @return
     */
    function diff($a = 'HEAD', $b = 'HEAD'){
        $commit = $this->Git->diff($a, $b);
        $this->set(array('a' => $a, 'b' => $b));
        $this->set(compact('commit'));
    }

    /**
     * blame
     * file blame
     *
     * @param $filepath
     * @return
     */
    function blame($filepath = null){
        $filepath = base64_decode($filepath);
        $blame = $this->Git->blame($filepath);
        $this->set('filepath', $filepath);
        $this->set(compact('blame'));
    }

    /**
     * tree
     * file browser
     *
     * @param $hash
     * @return
     */
    function tree($hash = 'HEAD'){
        Configure::write('debug', 0);
        $branch = $this->Git->currentBranch;
        $this->set(array(
                         'hash' => $hash,
                         'branch' =>  $branch,
                         ));
    }

    /**
     * ls_tree
     *
     * @param $arg
     * @return
     */
    function ls_tree(){
        $hash = ($this->params['url']['root'] == 'source') ? 'HEAD' :  $this->params['url']['root'];
        $this->layout = 'ajax';
        Configure::write('debug', 0);
        $tree = $this->Git->tree($hash);
        $this->set('tree', $tree);
    }

    /**
     * svn
     *
     * @param
     * @return
     */
    function svn(){
        $logs = $this->Svn->log();
        $this->set(compact('logs'));
    }
  }