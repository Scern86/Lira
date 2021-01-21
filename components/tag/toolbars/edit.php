<?php
defined('_DEXEC') or DIE;
if (!empty($data)) extract ($data);
$text = \Scern\Lira\Core\Text::getInstance();
?>
<div class="card bg-dark m-1" id="toolbar">
    <div class="card-header">
        <a href="/?com=tag&task=list" class="btn btn-secondary" title="<?=$text->back?>"><i class="fas fa-arrow-left"></i></a>
        &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
        <a href="#" class="btn btn-success" onclick="document.edit.action='/?com=tag&task=edit&id=<?=$id;?>'; document.edit.submit(); return false;" title="<?=$text->save_and_close?>"><i class="fas fa-save"></i> <i class="fas fa-times"></i></a>
        <a href="#" class="btn btn-warning" onclick="document.edit.action='/?com=tag&task=edit&id=<?=$id;?>&type=save'; document.edit.submit(); return false;" title="<?=$text->save?>"><i class="fas fa-save"></i></a>
        <a href="#" class="btn btn-info" onclick="document.edit.action='/?com=tag&task=edit&id=<?=$id;?>&type=new'; document.edit.submit(); return false;" title="<?=$text->save_and_new?>"><i class="fas fa-save"></i> <i class="fas fa-plus"></i></a>
    </div>
</div>
<script>
$(function() {
    var box = $('#toolbar'); // float-fixed block

    var top = box.offset().top - parseFloat(box.css('marginTop').replace(/auto/, 0));
    $(window).scroll(function(){
        var windowpos = $(window).scrollTop();
        if(windowpos < top) {
            box.css('position', 'static');
        } else {
            box.css('position', 'sticky');
            box.css('z-index', 1010);
            box.css('top',0);
        }
    });
});
</script>