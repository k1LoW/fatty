<?php
  /**
   * Fatty: Simple Git repogitory browser plugin for CakePHP.
   *
   */
  /**
   * TipHelper code license:
   *
   * @copyright   Copyright (C) 2010 by 101000code/101000LAB
   * @since       CakePHP(tm) v 1.2
   * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
   */
class TipHelper extends Helper {

    var $helpers = array('Html', 'Javascript');

    function afterLayout(){
        if (Configure::read('debug') < 2 && empty($this->settings['forceEnable'])) {
            $this->enabled = false;
            return;
        }

        parent::afterLayout();

        $view =& ClassRegistry::getObject('view');
        $view->output = $view->output;

        $tip = '';

        if (isset($view->viewVars['fattyBranch'])) {
            $style = 'background-color:#FF8929; color:#FFFFFF; font-weight:bold; margin:0px; line-height:1.4em; padding:2px 4px; position:absolute; top:0px;';
            if ($view->viewVars['fattyBranch'] != 'master') {
                $style = 'background-color:#2C6877; color:#FFFFFF; font-weight:bold; margin:0px; line-height:1.4em; padding:2px 4px; position:absolute; top:0px;';
            }
            $tip = "<div id='fattyBranch' style='" . $style . "'>" . $view->viewVars['fattyBranch'] . "</div>";
        }

        if (preg_match('#</body>#', $view->output) && $tip) {
            $view->output = preg_replace('#</body>#', $tip . "\n</body>", $view->output, 1);
        }

    }


  }