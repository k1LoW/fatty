<?php echo $html->link($page, array('action' => 'index', $page)); ?>

<?php foreach ($logs as $commit): ?>
<div id="<?php echo $commit['hash']; ?>" class="commit draggable droppable">
    <div class="info">
        <div class="comment">
            <?php echo nl2br(h($commit['comment'])); ?>
        </div>
        <div class="author"><span><?php echo $commit['Author']; ?></span><?php echo $commit['Date']; ?></div>
    </div>
    <div class="hash">        
        <div>commit:&nbsp;<?php echo $html->link($commit['hash'], array('action' => 'commit', $commit['hash'])); ?></div>
        <div>parent:&nbsp;<?php echo $html->link($commit['parent'], array('action' => 'commit', $commit['parent'])); ?></div>
        <?php if (!empty($commit['parent2'])): ?>
        <div>parent:&nbsp;<?php echo $html->link($commit['parent2'], array('action' => 'commit', $commit['parent2'])); ?></div>
        <?php endif; ?>
        <div>diff:&nbsp;&nbsp;&nbsp;<?php echo $html->link('HEAD', array('action' => 'diff', 'HEAD', $commit['hash'])); ?></div>
    </div>
</div>
<?php endforeach; ?>

<?php if ($next): ?>
<div id="autopaging" rel="next">
<?php echo $html->link(__('Next', true), array('action' => 'commit_logs', $next)); ?>
</div>
<?php endif; ?>