<?php 
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data); 
?>
<div class="card m-1" id="toolbar">
	<div class="card-header bg-dark">
		<a href="/?com=definition&task=list" class="btn btn-secondary" title="Назад"><i class="fas fa-arrow-left"></i></a>
		&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
		<a href="#" class="btn btn-success" onclick="document.add.action='/?com=definition&task=add'; document.add.submit(); return false;" title="Сохранить и закрыть"><i class="fas fa-save"></i> <i class="fas fa-times"></i></a>
		<a href="#" class="btn btn-warning" onclick="document.add.action='/?com=definition&task=add&type=save'; document.add.submit(); return false;" title="Сохранить"><i class="fas fa-save"></i></a>
		<a href="#" class="btn btn-info" onclick="document.add.action='/?com=definition&task=add&type=new'; document.add.submit(); return false;" title="Сохранить и создать"><i class="fas fa-save"></i> <i class="fas fa-plus"></i></a>
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