[
    <?php foreach($tree as $file): ?>
    {
        "text": "<?php echo $file['name']; ?>",
        <?php if ($file['type'] == 'tree') : ?>
        "id": "<?php echo $file['hash']; ?>",
        "hasChildren": true,
        <?php endif; ?>
        "classes": "<?php echo ($file['type'] == 'tree') ? 'folder' : 'file'; ?>"
    },
    <?php endforeach; ?>
]
