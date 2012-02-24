<div id="blame">
    <div class="title">
        <?php echo $filepath; ?>
        <?php echo $this->Html->link(__('history'), array('action' => 'commits', base64_encode($filepath))); ?>
    </div>
    <table>
        <?php $currentHash = ''; ?>
        <?php foreach ($blame as $line): ?>
        <?php if ($currentHash != $line['hash']): ?>
        <tr class="hash_head">
            <th class="commiter">
                <?php echo $this->Html->link(substr($line['hash'] , 0, 8) . '>>', array('action' => 'commit', str_replace('^', '', $line['hash']))); ?><?php echo $line['commiter']; ?>
                <?php echo date('Y-m-d', strtotime($line['date'])); ?>
            </th>
            <?php else: ?>
        <tr>
            <th class="commiter">
            </th>            
            <?php endif; ?>
        <?php $currentHash = $line['hash']; ?>
            <th class="line_number">
                <?php echo $line['line']; ?>
            </th>
            <td>
                <?php echo preg_replace('/ /','&nbsp;', h($line['code'])); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
