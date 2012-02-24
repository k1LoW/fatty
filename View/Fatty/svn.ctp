<h2>
    <?php echo __('Commit History: SVN'); ?>
</h2>
<?php if(!empty($logs)): ?>
<?php foreach ($logs as $commit): ?>
<div id="<?php echo $commit['rev']; ?>" class="commit draggable droppable">
<div class="info">
    <div class="comment">
        <?php echo nl2br(h($commit['comment'])); ?>
    </div>
    <div class="author"><span><?php echo $commit['Author']; ?></span><?php echo $commit['Date']; ?></div>
</div>
<div class="hash">        
    <div>rev:&nbsp;<?php echo $commit['rev']; ?></div>
</div>
</div>
<?php endforeach; ?>
<?php endif; ?>