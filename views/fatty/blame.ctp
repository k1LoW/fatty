<div id="blame">
    <div class="title">
        <?php echo $filepath; ?>
    </div>
    <table>
        <?php foreach ($blame as $line): ?>
        <tr>
            <th>
                <?php echo $html->link(substr($line['hash'] , 0, 8), array('action' => 'commit', str_replace('^', '', $line['hash']))); ?>
            </th>
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
