<?php
  /**
   * Fatty: Simple Git repogitory browser plugin for CakePHP.
   *
   */
if (!defined('FATTY_GIT_PATH')) {
    define('FATTY_GIT_PATH', '/usr/local/bin/git');
}

if (!defined('FATTY_GIT_DIR')) {
    define('FATTY_GIT_DIR', ROOT . DS . '.git' . DS);
}

if (!defined('FATTY_LOG_LIMIT')) {
    define('FATTY_LOG_LIMIT', 20);
}
