<?php
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