<h2>
    <?php __('File tree'); ?> <span>(<?php echo $branch; ?>)</span>
</h2>

<div>
    <ul id="repogitory" class="filetree treeview">        
    </ul>
</div>
<script type="text/javascript">
    $(function(){
    $("#repogitory").treeview({
    url: fattyBase + 'ls_tree/',
    })
    });
</script>

