<h2>
    <?php echo __('Commit'); ?> <span>(<?php echo $commit['hash']; ?>)
</h2>

<div class="commit">
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
    </div>
</div>

<div id="files">
    <ul>
        <?php foreach ($commit['diff'] as $file => $diff): ?>
        <li>
            <?php echo $file; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php echo $this->element('diff'); ?>