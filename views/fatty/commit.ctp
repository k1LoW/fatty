<h2>
    <?php __('Commit'); ?> <span>(<?php echo $commit['hash']; ?>)
</h2>

<div class="commit">
    <div class="info">
        <div class="comment">
            <?php echo nl2br(h($commit['comment'])); ?>
        </div>
        <div class="author"><span><?php echo $commit['Author']; ?></span><?php echo $commit['Date']; ?></div>
    </div>
    <div class="hash">        
        <div>commit:&nbsp;<?php echo $html->link($commit['hash'], array('action' => 'commit', $commit['hash'])); ?></div>
        <div>parent:&nbsp;<?php echo $html->link($commit['parent'], array('action' => 'commit', $commit['parent'])); ?></div>
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

<div id="diffs">
    <?php foreach ($commit['diff'] as $file => $diff): ?>
    <div class="diff">
        <div class="title">
            <?php echo $file; ?>
        </div>
        <?php foreach ($diff as $part): ?>
        <table>
            <?php foreach ($part as $n => $line): ?>
            <?php if (preg_match('/^([\+-])(.*)$/', $line, $matches)): ?>
            <tr class="<?php echo ($matches[1] == '+') ? 'green' : 'red'; ?>">
                <th>
                    <?php echo $matches[1]; ?>
                </th>
                <td>
                    <?php echo preg_replace('/ /','&nbsp;', h($matches[2])); ?>
                </td>
            </tr>
            <?php else: ?>
            <tr class="<?php echo ($n == '0') ? 'gray' : ''; ?>">
                <th>
                </th>
                <td>
                    <?php echo preg_replace('/ /','&nbsp;', h($line)); ?>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </table>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>
