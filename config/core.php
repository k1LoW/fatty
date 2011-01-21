<?php
  /**
   * Fatty: Simple Git repogitory browser plugin for CakePHP.
   *
   */
if (!defined('FATTY_GIT_PATH')) {
    if (Configure::read('Fatty.git_path')) {
        define('FATTY_GIT_PATH', Configure::read('Fatty.git_path'));
    } else {
        define('FATTY_GIT_PATH', '/usr/local/bin/git');
    }
}

if (!defined('FATTY_GIT_DIR')) {
    if (Configure::read('Fatty.git_dir')) {
        define('FATTY_GIT_DIR', Configure::read('Fatty.git_dir'));
    } else {
        define('FATTY_GIT_DIR', ROOT . DS . '.git' . DS);
    }
}

if (!defined('FATTY_LOG_LIMIT')) {
    if (Configure::read('Fatty.log_limit')) {
        define('FATTY_LOG_LIMIT', Configure::read('Fatty.log_limit'));
    } else {
        define('FATTY_LOG_LIMIT', 20);
    }
}

if (!defined('FATTY_SVN_PATH')) {
    if (Configure::read('Fatty.svn_path')) {
        define('FATTY_SVN_PATH', Configure::read('Fatty.svn_path'));
    } else {
        define('FATTY_SVN_PATH', '/usr/bin/svn');
    }
}
