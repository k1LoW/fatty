<?php
  /**
   * Fatty: Simple Git repogitory browser plugin for CakePHP.
   *
   */
  /**
   * TipHelper code license:
   *
   * @copyright   Copyright (C) 2010-2012 by 101000code/101000LAB
   * @since       CakePHP(tm) v 2.0
   * @license     http://www.opensource.org/licenses/mit-license.php The MIT License
   */
App::uses('AppHelper', 'View/Helper');
class TipHelper extends Helper {

    public $helpers = array('Html', 'Javascript');

    public function afterLayout($layoutFile){
        if (Configure::read('debug') < 2 && empty($this->settings['forceEnable'])) {
            $this->enabled = false;
            return;
        }

        parent::afterLayout($layoutFile);

        $tip = '';

        if (isset($this->_View->viewVars['fattyBranch'])) {
            $style = 'background-color:#FF8929; color:#FFFFFF; font-weight:bold; margin:0px; line-height:1.4em; padding:2px 4px; position:absolute; top:0px;';
            if ($this->_View->viewVars['fattyBranch'] != 'master') {
                $style = 'background-color:#2C6877; color:#FFFFFF; font-weight:bold; margin:0px; line-height:1.4em; padding:2px 4px; position:absolute; top:0px;';
            }
            $tip = "<div id='fattyBranch' style='" . $style . "'>" . $this->_View->viewVars['fattyBranch'] . "</div>";
        }

        if (preg_match('#</body>#', $this->_View->output) && $tip) {
            $this->_View->output = preg_replace('#</body>#', $tip . "\n</body>", $this->_View->output, 1);
        }

    }


  }