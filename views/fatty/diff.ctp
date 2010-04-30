<h2>
    <?php __('Diff'); ?> <span>
</h2>

<div id="diffhash">
    <div class="red">
        <?php echo $a; ?>    
    </div>
    <div class="green">
        <?php echo $b; ?>   
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