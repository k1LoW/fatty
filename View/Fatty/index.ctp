<h2>
    <?php echo __('Commit History'); ?> <span>(<?php echo $branch; ?>)</span>
</h2>

<?php foreach ($logs as $commit): ?>
<div id="<?php echo $commit['hash']; ?>" class="commit draggable droppable">
<div class="info">
    <div class="comment">
        <?php echo nl2br(h($commit['comment'])); ?>
    </div>
    <div class="author"><span><?php echo $commit['Author']; ?></span><?php echo $commit['Date']; ?></div>
</div>
<div class="hash">        
    <div>commit:&nbsp;<?php echo $this->Html->link($commit['hash'], array('action' => 'commit', $commit['hash'])); ?></div>
    <div>parent:&nbsp;<?php echo $this->Html->link($commit['parent'], array('action' => 'commit', $commit['parent'])); ?></div>
    <?php if (!empty($commit['parent2'])): ?>
    <div>parent:&nbsp;<?php echo $this->Html->link($commit['parent2'], array('action' => 'commit', $commit['parent2'])); ?></div>
    <?php endif; ?>
    <div>diff:&nbsp;&nbsp;&nbsp;<?php echo $this->Html->link('HEAD', array('action' => 'diff', 'HEAD', $commit['hash'])); ?></div>
</div>
</div>
<?php endforeach; ?>

<!--
<div class="paging">
    <?php if ($prev): ?>
    <?php echo $this->Html->link(__('<< prev', true), array('action' => 'index', $prev)); ?>
    <?php else: ?>

    <?php endif; ?>

    <?php if ($next): ?>
    <?php echo $this->Html->link(__('next >>', true), array('action' => 'index', $next)); ?>
    <?php else: ?>
    <?php endif; ?>
</div>
-->

<?php if ($next): ?>
<div id="autopaging" rel="next">
<?php echo $this->Html->link(__('Next'), array('action' => 'commit_logs', $next)); ?>
</div>
<?php endif; ?>