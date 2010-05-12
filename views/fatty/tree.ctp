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
    });

    $("span.file").live('click', function () {
    var $self = $(this);
    var filename = $self.text();
    var filepath = $self.parents("li").map(function() { return $(this).find('span.folder:first').text();}).get().reverse().join('/');
    if (filepath) {
    location.href = fattyBase + 'blame/' + base64.encodeStringAsUTF8(filepath + filename);
    } else {
    location.href = fattyBase + 'blame/' + base64.encodeStringAsUTF8(filename);
    }
    });
    });
</script>

