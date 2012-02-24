[
    <?php $first = true; ?>
    <?php foreach($tree as $file): ?>
    <?php echo ($first ? '' : ','; $first = false;  ?>
    {
        "text": <?php if ($file['type'] == 'tree') : ?>"<?php echo $file['name']; ?>"<?php else: ?>"<a href=\"#\"><?php echo $file['name']; ?></a>"<?php endif;?>,
        <?php if ($file['type'] == 'tree') : ?>
        "id": "<?php echo $file['hash']; ?>",
        "hasChildren": true,
        <?php endif; ?>
        "classes": "<?php echo ($file['type'] == 'tree') ? 'folder' : 'file'; ?>"
    }
    <?php endforeach; ?>
]
