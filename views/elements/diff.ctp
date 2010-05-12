<div id="diffs">
    <?php foreach ($commit['diff'] as $file => $diff): ?>
    <div class="diff">
        <div class="title">
            <?php echo $file; ?>
            <div>
                <?php echo $html->link(__('blame', true), array('action' => 'blame', base64_encode($file))); ?>
                <?php echo $html->link(__('history', true), array('action' => 'commits', base64_encode($file))); ?>
            </div>
        </div>
        <?php foreach ($diff as $part): ?>
        <table>
            <?php foreach ($part as $n => $line): ?>
            <?php if (preg_match('/^@@ -(\d+),?(\d*) \+(\d+),?(\d*) @@/',$line, $matches)): ?>
            <?php
              $mstart = $matches[1];
              $pstart = $matches[3];
            ?>
            <?php endif; ?>
            <?php if (preg_match('/^@@@ -(\d+),?(\d*) [\+-](\d+),?(\d*) ?[\+-]?(\d*),?(\d*) @@/',$line, $matches)): ?>
            <?php
              $mstart = $matches[1];
              $pstart = $matches[5];
            ?>
            <?php endif; ?>
            <?php if (preg_match('/^([\+-])(.*)$/', $line, $matches)): ?>
            <tr class="<?php echo ($matches[1] == '+') ? 'green' : 'red'; ?>">
            <th class="line_number">
                <?php if ($matches[1] == '-'): ?>
                <?php echo $mstart; $mstart++; ?>
                <?php else: ?>
                &nbsp;
                <?php endif; ?>
            </th>
            <th class="line_number">
                <?php if ($matches[1] == '+'): ?>
                <?php echo $pstart; $pstart++; ?>
                <?php else: ?>
                &nbsp;
                <?php endif; ?>
            </th>
            <th>
                <?php echo $matches[1]; ?>
            </th>
            <td>
                <?php echo preg_replace('/ /','&nbsp;', h($matches[2])); ?>
            </td>
        </tr>
        <?php else: ?>
        <tr class="<?php echo ($n == '0') ? 'gray' : ''; ?>">
        <th class="<?php echo ($n == '0' && !preg_match('/^@@ -(\d+),?(\d*) \+(\d+),?(\d*) @@/',$line)) ? '' : 'line_number'; ?>">
        <?php if ($n == '0'): ?>
        ...
        <?php else: ?>
        <?php echo $mstart; $mstart++; ?>
        <?php endif; ?>
    </th>
    <th class="<?php echo ($n == '0' && !preg_match('/^@@ -(\d+),?(\d*) \+(\d+),?(\d*) @@/',$line)) ? '' : 'line_number'; ?>">
    <?php if ($n == '0'): ?>
    ...
    <?php else: ?>
    <?php echo $pstart; $pstart++; ?>
    <?php endif; ?>
</th>
<th>
</th>
<td>
    <div>
        <?php echo preg_replace('/ /','&nbsp;', h($line)); ?>
    </div>
</td>
</tr>
<?php endif; ?>
<?php endforeach; ?>
</table>
<?php endforeach; ?>
</div>
<?php endforeach; ?>
</div>
