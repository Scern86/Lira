<?php
defined('_DEXEC') or DIE;
if(!empty($data)) extract($data); 
?>
<div class="card m-1" id="toolbar">
	<div class="card-header bg-dark">
		<a href="/?com=object&task=list" class="btn btn-secondary" title="Назад"><i class="fas fa-arrow-left"></i></a>
		&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
		<a href="#" class="btn btn-success" onclick="document.upload.action='/?com=object&task=upload'; document.upload.submit(); return false;" title="Загрузить"><i class="fas fa-download"></i></a>
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