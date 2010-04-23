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
        $limit = 20;
        $skip = $limit * ($page - 1);

        $count = $this->Git->count();
        $logs = $this->Git->log($limit, $skip);
        $branch = $this->Git->branch;


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

  }