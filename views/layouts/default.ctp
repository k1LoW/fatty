<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $html->charset(); ?>
        <title>
            <?php __('Fatty: Git + Cake'); ?>
            <?php //echo $title_for_layout; ?>
        </title>
        <?php
          echo $html->meta('icon');
          echo $html->css('/fatty/css/base');          
          echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1><?php echo $html->link(__('Fatty: Git + Cake', true), array('action' => 'index')); ?></h1>
            </div>
            <div id="content">

                <?php $session->flash(); ?>

                <?php echo $content_for_layout; ?>

            </div>
            <div id="footer">
                <?php if (preg_match('/^1\.2/', Configure::version())): ?>
                <!-- for CakePHP 1.2 -->
                <?php echo $html->link(
                  $html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework", true), 'border'=>"0")),
                  'http://www.cakephp.org/',
                  array('target'=>'_blank'), null, false
                  );
                ?>
                <?php else: ?>
                <?php echo $this->Html->link(
                  $this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
                  'http://www.cakephp.org/',
                  array('target' => '_blank', 'escape' => false)
                  );
                ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if (preg_match('/^1\.2/', Configure::version())): ?>
        <!-- for CakePHP 1.2 -->
        <?php echo $cakeDebug; ?>
        <?php endif; ?>
    </body>
</html>