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
    var $components = array('Fatty.Git');

    /**
     * index
     *
     */
    function index($page = 1){
        $limit = FATTY_LOG_LIMIT;
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
    function commit_logs($page = null){
        $this->layout = 'ajax';
        Configure::write('debug', 0);

        $limit = FATTY_LOG_LIMIT;
        $skip = $limit * ($page - 1);

        $count = $this->Git->count();
        $logs = $this->Git->log($limit, $skip);

        $prev = ($page > 1) ? $page - 1 : null;
        $next = ($count/$limit < $page) ? null : $page + 1;

        $this->set(array('limit' => $limit,
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
     * description
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
  }