<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo __('Fatty: Git + Cake'); ?>
            <?php //echo $title_for_layout; ?>
        </title>
        <?php
          echo $this->Html->meta('icon');
          echo $this->Html->css('/fatty/css/base');
          echo $this->Html->css('/fatty/css/jquery.treeview');
          echo $this->Html->script('/fatty/js/jquery-1.4.2.min');
          echo $this->Html->script('/fatty/js/jquery-ui-1.8.custom.min');
          echo $this->Html->script('/fatty/js/jquery.cookie');
          echo $this->Html->script('/fatty/js/jquery.treeview');
          echo $this->Html->script('/fatty/js/jquery.treeview.async');
          echo $this->Html->script('/fatty/js/base64');
          echo $this->Html->script('/fatty/js/fatty');
          echo $scripts_for_layout;
        ?>
        <script type="text/javascript">
            var fattyBase = '<?php echo $this->Html->url('/'); ?>fatty/fatty/';
        </script>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1><?php echo $this->Html->link(__('Fatty: Git + Cake'), array('action' => 'index')); ?></h1>
            </div>
            <div id="content">

                <?php $this->Session->flash(); ?>

                <?php echo $content_for_layout; ?>

            </div>
            <div id="footer">
                <?php echo $this->Html->link(
                  $this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework'), 'border' => '0')),
                  'http://www.cakephp.org/',
                  array('target' => '_blank', 'escape' => false)
                  );
                ?>
            </div>
        </div>
    </body>
</html>